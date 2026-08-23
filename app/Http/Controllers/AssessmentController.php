<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssessmentResult;
use App\Services\EngineService;
use App\Services\AssessmentResultService;
use App\Services\InsightService;
use App\Services\PersonalProfileService;
use App\Services\ExplanationService;
use App\Services\CareerPathService;
use App\Services\ScenarioService;
use App\Services\DecisionService;
use App\Services\StratifiedRandomAssessmentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    protected $engine;
    protected $resultService;

    public function __construct(EngineService $engine, AssessmentResultService $resultService)
    {
        $this->engine = $engine;
        $this->resultService = $resultService;
    }

    public function index()
    {
        $results = AssessmentResult::with(['identity'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('result.index', compact('results'));
    }

    /**
     * Menampilkan form asesmen dengan kuesioner (Step-27X).
     */
    public function form(Request $request, StratifiedRandomAssessmentService $stratifiedService)
    {
        $mode = $request->query('mode');

        if ($mode === 'trial') {
            // StratifiedRandomAssessmentService saat ini di-set untuk 20 soal
            $questions = collect($stratifiedService->draw());
        } elseif ($mode === 'cepat') {
            // Ambil 40 soal secara acak (bisa dikembangkan menjadi stratified 40)
            $questions = \App\Models\Question::inRandomOrder()->take(40)->get();
        } elseif ($mode === 'normal') {
            // 176 soal
            $questions = \App\Models\Question::orderBy('module')->orderBy('display_order')->get();
        } else {
            // Tampilkan modal pemilihan mode
            $questions = collect([]);
        }

        return view('assessment.test', compact('questions', 'mode'));
    }

    /**
     * Menampilkan detail hasil asesmen dengan Caching & Error Handling.
     */
    public function show(
        Request $request, 
        $id, 
        \App\Services\IdentityResolverService $identityResolver,
        InsightService $insightService,
        PersonalProfileService $profileService,
        ExplanationService $explanationService,
        CareerPathService $careerPathService,
        ScenarioService $scenarioService,
        DecisionService $decisionService,
        \App\Services\GeminiService $geminiService,
        $viewName = 'results'
    ) {
        // [T-36-06 FIX] Proteksi Akses diletakkan SEBELUM blok try agar abort(403)
        // tidak tertangkap oleh catch dan salah dilog sebagai "system error".
        $result = AssessmentResult::findOrFail($id);

        if (auth()->check()) {
            $userId = auth()->id();
            $isOwnerByUserId = $result->user_id === $userId;
            $isOwnerByIdentity = false;

            if (!$isOwnerByUserId && $result->identity_id) {
                $linkedIds = \App\Models\Identity::where('user_id', $userId)
                    ->where('identity_type', \App\Models\Identity::TYPE_PERSONAL)
                    ->first();

                if ($linkedIds) {
                    $allLinkedIds = \App\Models\Identity::getLinkedIdentityIds($linkedIds->id);
                    $isOwnerByIdentity = $allLinkedIds->contains($result->identity_id);
                }
            }

            if (!$isOwnerByUserId && !$isOwnerByIdentity) {
                abort(403);
            }
        } else {
            if ($result->session_id !== session()->getId()) {
                abort(403);
            }
        }

        // Data dasar untuk cache key & calculation
        $userId = auth()->id();
        $identityId = $result->identity_id;

        $allowedPreferences = ['stability', 'exploration'];
        $rawPref = $request->query('pref', 'exploration');
        $userPreference = in_array($rawPref, $allowedPreferences) ? $rawPref : 'exploration';

        $stabilityData = $profileService->calculateStability($userId, $identityId);
        $stabilityScore = $stabilityData['score'] ?? 1.0;

        try {
            $context = [
                'isAuthenticated' => auth()->check(),
                'potentialIdentity' => $identityResolver->detectPotentialIdentity(),
            ];

            // [STEP-36A] Caching Layer - DB-First Strategy
            // Jika narasi_json sudah tersimpan di database, gunakan langsung (tidak perlu generate ulang)
            // [V3] Update version to v3 for Gemini integration
            $cacheKey = "assessment_result_v5_{$id}_{$userId}_{$userPreference}";
            $cacheDuration = 600;

            // [T-36-08 FIX] Tangkap $this->engine ke variabel lokal agar dapat
            // dimasukkan eksplisit ke dalam scope closure Cache::remember.
            $engine = $this->engine;

            // [DB-FIRST] Cek apakah narasi sudah tersimpan di database
            // Jika ada param 'refresh', abaikan cache DB
            $forceRefresh = $request->has('refresh');

            // [DB-FIRST v5] Validasi bahwa data DB adalah narasi AI (punya key 'explanation' string, bukan array lama)
            $dbNarasi = $result->narasi_json;
            $dbIsValid = !empty($dbNarasi)
                && isset($dbNarasi['summary'])
                && isset($dbNarasi['explanation'])
                && is_string($dbNarasi['explanation']);

            if (!$forceRefresh && $dbIsValid) {
                Log::info('narasi_loaded_from_db_v5', ['result_id' => $id]);
                $cacheData = $dbNarasi;
            } else {
                $cacheData = Cache::remember($cacheKey, $cacheDuration, function() use (
                $result, $userPreference, $stabilityScore, $userId, $identityId,
                $insightService, $explanationService, $careerPathService, $scenarioService, $decisionService, $profileService, $geminiService,
                $engine
            ) {
                $summary = ""; // Akan digenerate oleh Gemini setelah Top N didapatkan
                $reasons = []; // Akan digenerate oleh Gemini
                $explanation = ""; // Akan digenerate oleh Gemini
                
                $previousResult = null;
                if ($result->identity_id) {
                    $previousResult = AssessmentResult::where('identity_id', $result->identity_id)
                        ->where('id', '<', $result->id)
                        ->latest('id')
                        ->first();
                } elseif ($result->session_id) {
                    $previousResult = AssessmentResult::where('session_id', $result->session_id)
                        ->where('id', '<', $result->id)
                        ->latest('id')
                        ->first();
                }
                $comparison = $insightService->generateComparison($result, $previousResult);

                $careerPaths = [];
                $explanation = [];
                $breakdown = [];
                $label = '';
                $skillGap = [];
                $educationPath = [];
                $growthSimulation = [];
                $actionPlan = [];
                $decisionScore = 0;
                $decisionReason = '';

                $rawTopResults = $result->result_top_n ?? [];
                if (!empty($rawTopResults)) {
                    $scoredTopResults = array_map(function ($prof) use ($decisionService, $stabilityScore, $userPreference) {
                        $prof['decision_score'] = $decisionService->calculateDecisionScore($prof, $stabilityScore, $userPreference);
                        $prof['confidence'] = $decisionService->confidenceLevel($prof['decision_score']);
                        return $prof;
                    }, $rawTopResults);

                    usort($scoredTopResults, fn($a, $b) => $b['decision_score'] <=> $a['decision_score']);
                    $sortedTopN = $scoredTopResults;

                    foreach ($sortedTopN as $index => $prof) {
                        $careerPaths[$index] = $careerPathService->generatePath($prof);
                    }

                    $top = $sortedTopN[0];
                    
                    // [AI-INTEGRATION] Generate Narasi via Gemini API
                    $summaryData = [
                        'professions' => array_slice($sortedTopN, 0, 10),
                        'riasec' => $result->input_riasec,
                        'trait' => $result->input_trait,
                        'environment' => $result->input_environment ?? null,
                    ];
                    
                    $aiResponse = $geminiService->generateAssessmentSummary($summaryData);
                    
                    // Gunakan hasil AI untuk Summary, Explanation, dan Reasons
                    $summary = $aiResponse['summary'] ?? 'Ringkasan tidak tersedia.';
                    $explanation = $aiResponse['explanation'] ?? 'Penjelasan detail tidak tersedia.';
                    $reasons = $aiResponse['reasons'] ?? [];

                    $breakdown = $explanationService->breakdown($result, $top);
                    $label = $explanationService->interpretScore($top['score'] ?? 0);
                    
                    $skillGap = $careerPathService->skillGap($result, $top);
                    $educationPath = $careerPathService->educationPath($top);
                    $growthSimulation = $careerPathService->simulateGrowth($result, $top);
                    $actionPlan = $careerPathService->actionPlan($top);

                    $decisionScore = $top['decision_score'];
                    $decisionReason = $decisionService->explainDecision($top, $stabilityScore, $userPreference);
                }

                $scenarios = $scenarioService->generateScenarios($result);
                $scenarioResults = [];
                foreach ($scenarios as $key => $scenarioData) {
                    $engineInput = [
                        'trait' => $scenarioData['trait'],
                        'riasec' => $scenarioData['riasec'],
                        'environment' => $scenarioData['environment'],
                        'domain' => $result->domain
                    ];
                    
                    Log::info("Engine Call for Scenario: {$key} in Result: {$result->id}");
                    
                    // [T-36-08 FIX] Gunakan $engine (captured variable), bukan $this->engine
                    $output = $engine->run($engineInput, 1);
                    if (!empty($output['results'])) {
                        $scenarioResults[$key] = [
                            'label' => $scenarioData['label'],
                            'description' => $scenarioData['description'],
                            'insight' => $scenarioService->scenarioInsight($key),
                            'top_profession' => $output['results'][0],
                            'delta' => ($key !== 'current') ? $scenarioService->calculateDelta($scenarioResults['current']['top_profession'] ?? [], $output['results'][0]) : null
                        ];
                    }
                }

                foreach ($scenarioResults as $key => &$sData) {
                    if ($key !== 'current') {
                        $sData['score_diff'] = $sData['top_profession']['score'] - $scenarioResults['current']['top_profession']['score'];
                    }
                }

                $topComparison = null;
                if (!empty($sortedTopN) && count($sortedTopN) >= 2) {
                    $topComparison = $explanationService->compare($sortedTopN[0], $sortedTopN[1]);
                }

                $profile = $profileService->aggregate($userId, $identityId);
                $trend = $profileService->detectTrend($userId, $identityId);
                $stability = $profileService->calculateStability($userId, $identityId);
                $adaptiveInsight = $insightService->generateAdaptiveInsight($profile, $trend, $stability);

                $traitMatriks = ['high' => [], 'medium' => [], 'low' => []];
                if (!empty($result->input_trait)) {
                    $traits = $result->input_trait;
                    asort($traits); // Urutkan dari terendah ke tertinggi
                    
                    $total = count($traits);
                    $highCount = ceil($total * 0.3); // 30% teratas
                    $lowCount = floor($total * 0.3);  // 30% terbawah
                    
                    $traitMatriks['low'] = array_keys(array_slice($traits, 0, $lowCount, true));
                    $traitMatriks['high'] = array_keys(array_slice($traits, -$highCount, null, true));
                    
                    // Sisanya masuk medium
                    $allKeys = array_keys($traits);
                    $traitMatriks['medium'] = array_diff($allKeys, $traitMatriks['low'], $traitMatriks['high']);
                }

                return [
                    'summary' => $summary,
                    'reasons' => $reasons,
                    'comparison' => $comparison,
                    'explanation' => $explanation,
                    'breakdown' => $breakdown,
                    'label' => $label,
                    'careerPaths' => $careerPaths,
                    'skillGap' => $skillGap,
                    'educationPath' => $educationPath,
                    'growthSimulation' => $growthSimulation,
                    'actionPlan' => $actionPlan,
                    'scenarios' => $scenarios,
                    'scenarioResults' => $scenarioResults,
                    'decisionScore' => $decisionScore,
                    'decisionReason' => $decisionReason,
                    'topComparison' => $topComparison,
                    'profile' => $profile,
                    'trend' => $trend,
                    'stability' => $stability,
                    'adaptiveInsight' => $adaptiveInsight,
                    'sortedTopN' => $sortedTopN ?? [],
                    'traitMatriks' => $traitMatriks
                ];
            }); // end Cache::remember
            } // end else (narasi_json not in DB)

            // [DB-SAVE v5] Selalu update narasi_json dengan data terbaru dari AI
            // Pastikan data AI tersimpan sehingga request berikutnya tidak perlu memanggil Gemini lagi
            if (!empty($cacheData['summary']) && !empty($cacheData['explanation'])) {
                $result->update(['narasi_json' => $cacheData]);
                Log::info('narasi_saved_to_db_v5', ['result_id' => $id]);
            }

            $result->result_top_n = $cacheData['sortedTopN'];

            // [STEP-36B] Log Aktivitas: Recommendation Accessed
            Log::info('recommendation_accessed', [
                'result_id' => $id,
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'preference' => $userPreference,
                'timestamp' => now()->toDateTimeString()
            ]);

            $assessmentCount = $result->identity ? $result->identity->assessments()->count() : 1;

            // Label Mappings for UI
            $traitLabels = [
                0 => 'Openness',
                1 => 'Conscientiousness',
                2 => 'Extraversion',
                3 => 'Agreeableness',
                4 => 'Emotional Stability',
            ];

            $riasecLabels = [
                0 => 'Realistic',
                1 => 'Investigative',
                2 => 'Artistic',
                3 => 'Social',
                4 => 'Enterprising',
                5 => 'Conventional',
            ];

            $envLabels = [
                0 => 'Terstruktur',
                1 => 'Kolaboratif',
                2 => 'Dinamis',
                3 => 'High Pressure',
                4 => 'Formal',
                5 => 'Outdoor',
            ];

            return view($viewName, array_merge([
                'result' => $result,
                'context' => $context,
                'userPreference' => $userPreference,
                'assessmentCount' => $assessmentCount,
                'traitLabels' => $traitLabels,
                'riasecLabels' => $riasecLabels,
                'envLabels' => $envLabels,
                'riasecIndexMap' => ['R', 'I', 'A', 'S', 'E', 'C'], // Added to ensure views have it
            ], $cacheData));

        } catch (\Throwable $e) {
            // [STEP-36C] Graceful Fallback
            // [T-36-04 FIX] Full trace hanya di-log, tidak dieksposes ke user.
            // [T-36-01 FIX] Menggunakan redirect ke URL statis yang pasti ada.
            report($e); // Laravel built-in: log ke storage/logs
            Log::error('Assessment Result Failed to Load', [
                'id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return redirect('/assessment')
                ->with('error', 'Maaf, terjadi kesalahan saat memuat hasil asesmen. Silakan coba beberapa saat lagi.');
        }
    }

    /**
     * Memproses data asesmen dan menghasilkan rekomendasi.
     */
    public function run(
        Request $request, 
        \App\Services\IdentityResolverService $identityResolver, 
        PersonalProfileService $profileService,
        \App\Services\ScoringService $scoringService
    ) {
        $request->validate([
            'answers' => 'required|array',
            'domain' => 'nullable|string',
            'mode' => 'nullable|string'
        ]);

        // [VALIDITY CHECK] Cek apakah user menjawab asal-asalan
        $validity = $scoringService->checkValidity($request->answers);
        if (!$validity['is_valid']) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal: ' . $validity['reason'] . ' Silakan ulangi asesmen dengan lebih sungguh-sungguh.'
            ], 422);
        }

        // [STEP-27X-C] Map answers (1-5) to vectors
        $user = $scoringService->mapAnswersToVectors($request->answers);
        $user['domain'] = $request->domain ?? 'umum';

        $userId = auth()->id();
        $identityId = null;
        if ($userId) {
            $personalIdentity = \App\Models\Identity::where('user_id', $userId)
                ->where('identity_type', \App\Models\Identity::TYPE_PERSONAL)
                ->first();
            $identityId = $personalIdentity ? $personalIdentity->id : null;
        }

        $aggregatedProfile = $profileService->aggregate($userId, $identityId);
        $engineInput = $user;

        if (!empty($aggregatedProfile) && !empty($aggregatedProfile['trait'])) {
            foreach (['trait', 'riasec', 'environment'] as $dim) {
                if (isset($user[$dim]) && isset($aggregatedProfile[$dim])) {
                    foreach ($user[$dim] as $key => $val) {
                        if (isset($aggregatedProfile[$dim][$key])) {
                            $engineInput[$dim][$key] = ($val + $aggregatedProfile[$dim][$key]) / 2;
                        }
                    }
                }
            }
        }

        try {
            $startTime = microtime(true);
            $engineData = $this->engine->run($engineInput, null);
            $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2);
            
            $allResults = $engineData['results'];

            $isAdaptive = !empty($aggregatedProfile) && !empty($aggregatedProfile['trait']);
            $context = [
                'user_id'        => auth()->id(),
                'session_id'     => session()->getId(),
                'mode'           => $request->input('mode', 'normal'),
                'tenant_id'      => null,
                'domain'         => $user['domain'],
                'weights'        => $engineData['weights'] ?? [
                    'trait'       => 0.5,
                    'riasec'      => 0.3,
                    'environment' => 0.2
                ],
                'execution_time_ms' => $executionTimeMs,
                'is_adaptive'    => $isAdaptive,
                'adapted_input'  => $isAdaptive ? [
                    'trait'       => $engineInput['trait'],
                    'riasec'      => $engineInput['riasec'],
                    'environment' => $engineInput['environment'],
                ] : null,
            ];

            $savedResult = $this->resultService->save($user, $allResults, $context);

            Log::info('assessment_created', [
                'result_id' => $savedResult->id,
                'user_id' => auth()->id(),
                'identity_id' => $savedResult->identity_id,
                'mode' => $context['mode'] ?? 'public',
                'execution_time_ms' => $context['execution_time_ms'],
                'timestamp' => now()->toDateTimeString()
            ]);

            $top3 = array_slice($allResults, 0, 3);

            return response()->json([
                'success'   => true,
                'result_id' => $savedResult->id,
                'results'   => $top3,
                'inputs'    => $user
            ]);

        } catch (\Throwable $e) {
            Log::error('Assessment Engine Failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace'   => $e->getTraceAsString(),
                'inputs'  => $user ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan teknis: ' . $e->getMessage()
            ], 500);
        }
    }
}
