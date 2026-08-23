<?php

namespace App\Services;

use App\Models\AssessmentResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessmentResultService
{
    protected $identityResolver;

    public function __construct(IdentityResolverService $identityResolver)
    {
        $this->identityResolver = $identityResolver;
    }

    /**
     * Menyimpan hasil asesmen ke dalam database.
     *
     * @param array $input Data input (trait, riasec, environment)
     * @param array $results Data output (full score map)
     * @param array $context Konteks tambahan (user_id, session_id, domain, weights)
     * @return AssessmentResult
     */
    public function save(array $input, array $results, array $context): AssessmentResult
    {
        return DB::transaction(function () use ($input, $results, $context) {
            // 1. Tentukan Top N (misal 3 teratas) untuk disimpan secara spesifik
            $topN = array_slice($results, 0, 3);

            // 2. Ambil score tertinggi (Fallback Safety)
            $topScore = (isset($results[0]) && is_array($results[0])) 
                        ? ($results[0]['score'] ?? null) 
                        : null;

            // 3. Susun Metadata terstandarisasi
            $metadata = [
                'engine_version' => 'v1.0',
                'request' => [
                    'ip'         => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'request_id' => (string) Str::uuid(),
                ],
                'runtime' => [
                    'timestamp'        => now()->toDateTimeString(),
                    'execution_time_ms' => $context['execution_time_ms'] ?? 0,
                ],
                // [FIX BUG-05] Simpan input adaptif untuk auditabilitas & reproduksibilitas hasil
                'adaptive' => [
                    'is_adaptive'   => $context['is_adaptive'] ?? false,
                    'adapted_input' => $context['adapted_input'] ?? null,
                ],
            ];

            // 4. Resolusi Identitas & Konteks Strategis
            $identity = $this->identityResolver->resolve($context);
            $mode = $context['mode'] ?? 'public';
            $tenantId = $context['tenant_id'] ?? $identity->tenant_id;

            // 5. Simpan ke database menggunakan Model
            return AssessmentResult::create([
                'user_id' => $context['user_id'] ?? null,
                'session_id' => $context['session_id'] ?? null,
                'identity_id' => $identity->id,
                'assessment_version' => 'v1',
                'mode' => $mode,
                'tenant_id' => $tenantId,
                'domain' => $context['domain'] ?? null,
                
                'input_trait' => $input['trait'],
                'input_riasec' => $input['riasec'],
                'input_environment' => $input['environment'],
                
                'weights' => $context['weights'],
                
                'result_top_n' => $topN,
                'result_scores' => $results,
                'top_score' => $topScore,
                
                'metadata' => $metadata
            ]);
        });
    }
}
