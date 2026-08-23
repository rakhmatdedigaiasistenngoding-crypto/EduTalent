<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom narasi_json untuk menyimpan semua hasil komputasi
     * narasi, career path, skill gap, action plan, dsb. agar tidak perlu
     * di-generate ulang setiap kali halaman dibuka.
     */
    public function up(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            if (!Schema::hasColumn('assessment_results', 'narasi_json')) {
                $table->json('narasi_json')->nullable()->after('metadata')
                      ->comment('Menyimpan semua narasi hasil generate: summary, reasons, careerPaths, skillGap, educationPath, growthSimulation, actionPlan, explanation, sortedTopN');
            }
        });
    }

    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->dropColumnIfExists('narasi_json');
        });
    }
};
