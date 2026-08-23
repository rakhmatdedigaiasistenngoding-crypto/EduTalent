<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthCheckController extends Controller
{
    /**
     * Mengecek kesehatan sistem secara keseluruhan.
     */
    public function __invoke()
    {
        $status = [
            'app' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'services' => [
                'database' => $this->checkDatabase(),
                'cache' => $this->checkCache(),
                'storage' => $this->checkStorage(),
            ]
        ];

        // Jika ada satu pun service yang fail, kembalikan status 503 (Service Unavailable)
        $isHealthy = !in_array('error', array_values($status['services']));
        
        if (!$isHealthy) {
            $status['app'] = 'unhealthy';
            return response()->json($status, 503);
        }

        return response()->json($status);
    }

    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return 'ok';
        } catch (\Exception $e) {
            return 'error';
        }
    }

    private function checkCache()
    {
        try {
            $testKey = 'health_check_test';
            Cache::put($testKey, true, 10);
            $value = Cache::get($testKey);
            Cache::forget($testKey);
            
            return $value === true ? 'ok' : 'error';
        } catch (\Exception $e) {
            return 'error';
        }
    }

    private function checkStorage()
    {
        try {
            // 1. Real Write Test (Metode paling akurat di Windows)
            $testFile = storage_path('logs/health_check_test.txt');
            $canWrite = @file_put_contents($testFile, 'test') !== false;
            
            if ($canWrite) {
                @unlink($testFile); // Hapus file tes setelah berhasil
                $isWritable = true;
            } else {
                $isWritable = false;
            }

            // 2. Cek apakah symlink public storage sudah ada
            $isLinkExists = file_exists(public_path('storage'));

            if (!$isWritable) return 'error_permissions';
            if (!$isLinkExists) return 'error_missing_symlink';
            
            return 'ok';
        } catch (\Exception $e) {
            return 'error';
        }
    }
}
