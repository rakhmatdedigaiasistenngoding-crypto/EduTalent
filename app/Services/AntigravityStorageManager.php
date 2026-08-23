<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use File;

class AntigravityStorageManager
{
    /**
     * Nama disk yang dikonfigurasi di filesystems.php
     */
    protected $disk = 'google';

    /**
     * Sinkronisasikan folder dokumen ke Google Drive dengan folder per sesi
     * 
     * @return array
     */
    public function sync()
    {
        try {
            // Nama folder sesi berdasarkan waktu saat ini
            $sessionName = 'SESSION_' . date('Ymd_His');
            
            $results = [
                'status' => 'success',
                'session' => $sessionName,
                'files_uploaded' => 0,
                'timestamp' => now()->toDateTimeString()
            ];

            // Target folder di dokumen
            $sourcePath = base_path('dokumen');
            
            if (!File::isDirectory($sourcePath)) {
                throw new \Exception("Folder 'dokumen' tidak ditemukan di " . $sourcePath);
            }

            // Ambil semua file di folder dokumen (rekursif)
            $files = File::allFiles($sourcePath);

            foreach ($files as $file) {
                // Tentukan path relatif (misal: manajemen/log.md)
                $relativePath = $file->getRelativePathname();
                
                // Path tujuan di Drive: SESSION_timestamp/manajemen/log.md
                $targetPath = $sessionName . '/' . $relativePath;
                
                // Upload
                Storage::disk($this->disk)->put($targetPath, fopen($file->getRealPath(), 'r'));
                $results['files_uploaded']++;
            }

            Log::info("AntigravityStorageManager: Sinkronisasi sesi $sessionName berhasil.", $results);
            return $results;

        } catch (\Exception $e) {
            Log::error("AntigravityStorageManager: Gagal melakukan sinkronisasi. " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
