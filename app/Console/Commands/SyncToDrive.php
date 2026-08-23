<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AntigravityStorageManager;

class SyncToDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antigravity:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi file proyek dan log pengerjaan ke Google Drive (Antigravity Storage Manager)';

    /**
     * Execute the console command.
     */
    public function handle(AntigravityStorageManager $manager)
    {
        $this->info('🚀 Memulai sinkronisasi ke Google Drive...');

        $result = $manager->sync();

        if ($result['status'] === 'success') {
            $this->info('✅ Sinkronisasi berhasil pada: ' . $result['timestamp']);
            $this->line("📂 Sesi: " . $result['session']);
            $this->line("📤 Total file terupload: " . $result['files_uploaded']);
        } else {
            $this->error('❌ Sinkronisasi Gagal: ' . $result['message']);
        }
    }
}
