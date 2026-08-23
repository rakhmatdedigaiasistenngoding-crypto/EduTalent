<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('professions', function (Blueprint $table) {
            // Menambah kolom Work Values (30-36 soal di bank soal)
            $table->json('work_values')->nullable()->after('environment')
                  ->comment('Target profil Nilai Kerja (6 dimensi)');
            
            // Menambah kolom Metadata untuk informasi pendukung di UI Results
            $table->json('metadata')->nullable()->after('work_values')
                  ->comment('Informasi tambahan: gaji, deskripsi, prasyarat pendidikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn(['work_values', 'metadata']);
        });
    }
};
