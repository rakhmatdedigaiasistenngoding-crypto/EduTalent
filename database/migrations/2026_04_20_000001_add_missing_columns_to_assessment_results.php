<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * [FIX TEMUAN-1] Menambahkan kolom `mode` dan `tenant_id` ke tabel assessment_results.
     * Kolom ini digunakan oleh AssessmentResultService::save() namun tidak ada di migration awal.
     */
    public function up(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            // Tambah setelah kolom identity_id (jika sudah ada) atau setelah session_id
            if (!Schema::hasColumn('assessment_results', 'mode')) {
                $table->string('mode')->default('public')->after('session_id');
            }

            if (!Schema::hasColumn('assessment_results', 'tenant_id')) {
                $table->string('tenant_id')->nullable()->index()->after('mode');
            }

            // Tambah identity_id jika belum ada (sebagai fallback safety)
            if (!Schema::hasColumn('assessment_results', 'identity_id')) {
                $table->unsignedBigInteger('identity_id')->nullable()->index()->after('tenant_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->dropColumnIfExists('mode');
            $table->dropColumnIfExists('tenant_id');
        });
    }
};
