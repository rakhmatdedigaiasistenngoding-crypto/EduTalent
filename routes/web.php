<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\AdminDashboardController;
use App\Services\EngineService;

// [T-36-FIX] Halaman Login / Identitas Sementara
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'handleLogin'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout.post');

Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard Area
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/feedback-metrics', [\App\Http\Controllers\FeedbackController::class, 'metrics'])->name('admin.feedback_metrics');
});

// Endpoint Monitoring (Production Ready)
Route::get('/health', HealthCheckController::class)->middleware('throttle:5,1');
Route::get('/health-basic', fn() => ['status' => 'ok']);

// Route untuk Halaman Asesmen
// [T-36-03 FIX] /assessment → form pengisian (bukan riwayat)
Route::get('/assessment', [AssessmentController::class, 'form'])->name('assessment.form');
// [T-36-07 FIX] /assessment/history → riwayat via method history() yang benar
Route::get('/assessment/history', [AssessmentController::class, 'index'])->name('assessment.history');
Route::get('/assessment/result/{id}', [AssessmentController::class, 'show'])->name('assessment.show');
Route::post('/feedback/submit', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.submit');
Route::post('/assessment/run', [AssessmentController::class, 'run'])->middleware('throttle:10,1');

Route::get('/debug-engine', function () {
    $input = [
        "trait" => [0.8, 0.7, 0.75],
        "riasec" => [0.8, 0.2, 0.3, 0.4, 0.5, 0.6],
        "environment" => [0.7, 0.6, 0.65]
    ];

    $engine = app(EngineService::class);
    $result = $engine->run($input);

    return response()->json($result);
});

Route::get('/dashboard-user', function () {
    $userId = auth()->id();
    $sessionId = session()->getId();

    $latest = \App\Models\AssessmentResult::when($userId, function($q) use ($userId) {
            return $q->where('user_id', $userId);
        }, function($q) use ($sessionId) {
            return $q->where('session_id', $sessionId);
        })
        ->latest()
        ->first();

    if ($latest) {
        return redirect()->route('assessment.show', $latest->id);
    }
    return redirect()->route('assessment.history');
})->name('dashboard.user');

Route::get('/test-asesmen', [AssessmentController::class, 'form']);

Route::get('/debug-assessment', function () {
    $mockQuestions = collect([
        ['id' => 1, 'text' => 'Saya senang mencoba hal-hal baru yang menantang kreativitas saya.'],
        ['id' => 2, 'text' => 'Saya lebih suka bekerja dalam tim daripada sendirian.'],
        ['id' => 3, 'text' => 'Saya sangat teliti dalam mengerjakan tugas yang mendetail.'],
        ['id' => 4, 'text' => 'Saya merasa nyaman memimpin sebuah kelompok atau proyek.'],
        ['id' => 5, 'text' => 'Saya tertarik mempelajari bagaimana sebuah mesin bekerja.'],
        ['id' => 6, 'text' => 'Saya senang membantu orang lain menyelesaikan masalah mereka.'],
    ]);
    return view('assessment.test', ['questions' => $mockQuestions]);
});

// Unified Dynamic Detail Pages Logic
// Unified Dynamic Detail Pages Logic (Terbuka untuk Guest & Auth)
$detailPages = ['psikometrik', 'peta-pendidikan', 'peta-profesi', 'pengembangan-diri'];

foreach ($detailPages as $page) {
    Route::get('/' . $page, function () use ($page) {
        $userId = auth()->id();
        $sessionId = session()->getId();

        // Cari hasil asesmen terakhir berdasarkan login atau session
        $latest = \App\Models\AssessmentResult::when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            }, function($q) use ($sessionId) {
                return $q->where('session_id', $sessionId);
            })
            ->latest()
            ->first();
        
        if (!$latest) {
            return redirect()->route('assessment.form')->with('info', 'Silakan lakukan asesmen terlebih dahulu untuk melihat halaman ini.');
        }

        return app(AssessmentController::class)->show(request(), $latest->id, 
            app(\App\Services\IdentityResolverService::class),
            app(\App\Services\InsightService::class),
            app(\App\Services\PersonalProfileService::class),
            app(\App\Services\ExplanationService::class),
            app(\App\Services\CareerPathService::class),
            app(\App\Services\ScenarioService::class),
            app(\App\Services\DecisionService::class),
            app(\App\Services\GeminiService::class),
            $page
        );
    })->name($page);

    Route::get('/' . $page . '/pdf', function () use ($page) {
        $userId = auth()->id();
        $sessionId = session()->getId();

        $latest = \App\Models\AssessmentResult::when($userId, function($q) use ($userId) {
                return $q->where('user_id', $userId);
            }, function($q) use ($sessionId) {
                return $q->where('session_id', $sessionId);
            })
            ->latest()
            ->first();
        
        if (!$latest) {
            return redirect()->route('assessment.form')->with('info', 'Silakan lakukan asesmen terlebih dahulu untuk melihat halaman ini.');
        }

        // Panggil controller tapi arahkan ke view khusus PDF
        $view = app(AssessmentController::class)->show(request(), $latest->id, 
            app(\App\Services\IdentityResolverService::class),
            app(\App\Services\InsightService::class),
            app(\App\Services\PersonalProfileService::class),
            app(\App\Services\ExplanationService::class),
            app(\App\Services\CareerPathService::class),
            app(\App\Services\ScenarioService::class),
            app(\App\Services\DecisionService::class),
            app(\App\Services\GeminiService::class),
            'pdf.' . $page // View yang diload akan menjadi pdf/psikometrik.blade.php dsb
        );

        if ($view instanceof \Illuminate\View\View) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHtml($view->render());
            // Konfigurasi tambahan untuk PDF
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download("Laporan_{$page}_SA-".sprintf('%03d', $latest->id).".pdf");
        }

        return abort(500, "Gagal meng-generate PDF");
    })->name($page . '.pdf');
}

// Route Laporan Lengkap (semua bagian dalam 1 PDF)
Route::get('/laporan-lengkap/pdf', function () {
    $userId    = auth()->id();
    $sessionId = session()->getId();

    $latest = \App\Models\AssessmentResult::when($userId, function($q) use ($userId) {
            return $q->where('user_id', $userId);
        }, function($q) use ($sessionId) {
            return $q->where('session_id', $sessionId);
        })->latest()->first();

    if (!$latest) {
        return redirect()->route('assessment.form')->with('info', 'Silakan lakukan asesmen terlebih dahulu.');
    }

    // [PDF-FRESH] Reset narasi_json dan cache agar data selalu diregenerasi segar untuk PDF
    $latest->update(['narasi_json' => null]);
    \Illuminate\Support\Facades\Cache::forget("assessment_result_v1_{$latest->id}_{$userId}_exploration");
    \Illuminate\Support\Facades\Cache::forget("assessment_result_v1_{$latest->id}_{$userId}_stability");

    $view = app(AssessmentController::class)->show(request(), $latest->id,
        app(\App\Services\IdentityResolverService::class),
        app(\App\Services\InsightService::class),
        app(\App\Services\PersonalProfileService::class),
        app(\App\Services\ExplanationService::class),
        app(\App\Services\CareerPathService::class),
        app(\App\Services\ScenarioService::class),
        app(\App\Services\DecisionService::class),
        app(\App\Services\GeminiService::class),
        'pdf.laporan-lengkap'
    );

    if ($view instanceof \Illuminate\View\View) {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHtml($view->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->set_option('isRemoteEnabled', true);
        $pdf->set_option('isFontSubsettingEnabled', true);
        $name = auth()->user()->name ?? $latest->identity->name ?? 'Mahasiswa';
        $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $name);
        return $pdf->download("Laporan_Lengkap_{$safeName}_SA-".sprintf('%03d', $latest->id).".pdf");
    }

    return abort(500, "Gagal meng-generate PDF");
})->name('laporan-lengkap.pdf');

Route::get('/seed-questions', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'QuestionSeeder']);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengimpor 176 soal ke database.',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/migrate-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return response()->json([
            'success' => true,
            'message' => 'Migrasi database berhasil.',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});

// Route untuk Identity Linking
Route::post('/identity/link', [\App\Http\Controllers\IdentityController::class, 'link'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('identity.link');

Route::post('/api/link-token', [\App\Http\Controllers\IdentityController::class, 'linkApi'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('api.identity.link');

Route::post('/api/link-session', [\App\Http\Controllers\IdentityController::class, 'linkSession'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('api.identity.link.session');

// Route migrasi (development only)
Route::get('/migrate-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response('<pre style="font-family:monospace;padding:20px;background:#1a1a1a;color:#0f0;min-height:100vh;">'
            . '✅ Migration selesai:<br><br>' . htmlspecialchars($output) . '</pre>');
    } catch (\Exception $e) {
        return response('<pre style="font-family:monospace;padding:20px;background:#1a1a1a;color:#f55;min-height:100vh;">'
            . '❌ Error: ' . htmlspecialchars($e->getMessage()) . '</pre>', 500);
    }
});
