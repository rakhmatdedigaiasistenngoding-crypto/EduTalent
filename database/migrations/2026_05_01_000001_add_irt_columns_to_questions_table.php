<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Tambah kolom IRT & metadata semantik ke tabel questions.
 *
 * Tujuan:
 * - Menambah kolom `module` untuk membedakan 4 modul asesmen.
 * - Menambah kolom `sub_dimension` agar dimensi bersifat semantik.
 * - Menambah kolom `is_reflective` sebagai flag eksplisit item negatif.
 * - Menambah kolom `display_order` untuk pengurutan.
 * - Menambah kolom parameter IRT: `discrimination_a` dan `difficulty_b`.
 *
 * PENTING: Migration ini bersifat ADDITIVE (tidak menghapus kolom lama).
 * Data lama di kolom `dimension` dan `key` tetap dipertahankan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // 1. Modul utama asesmen (level tertinggi pengelompokan)
            //    Nilai: 'karakter' | 'minat' | 'nilai_kerja' | 'preferensi_lingkungan'
            $table->string('module', 30)->nullable()->after('id')
                  ->comment('Modul utama: karakter, minat, nilai_kerja, preferensi_lingkungan');

            // 2. Sub-dimensi semantik (misal: 'openness', 'realistic', 'stabilitas')
            $table->string('sub_dimension', 50)->nullable()->after('module')
                  ->comment('Sub-dimensi semantik, menggantikan kolom key yang numerik');

            // 3. Flag item reflektif (pertanyaan negatif/reverse-scored)
            //    Menggantikan konvensi weight < 0 yang ambigu
            $table->boolean('is_reflective')->default(false)->after('weight')
                  ->comment('True jika pertanyaan bersifat negatif (perlu reverse scoring)');

            // 4. Urutan tampil soal dalam satu sesi
            $table->unsignedSmallInteger('display_order')->default(0)->after('is_reflective')
                  ->comment('Urutan tampil soal dalam rendering form');

            // 5. Parameter IRT - Model 2PL (Two-Parameter Logistic)
            //    a = discrimination (daya beda), default 1.0 (model Rasch)
            //    b = difficulty (tingkat kesulitan), default 0.0 (tengah skala)
            //    Diisi dari hasil kalibrasi fase uji coba. Nilai null = belum dikalibrasi.
            $table->decimal('discrimination_a', 6, 4)->default(1.0000)->nullable()->after('display_order')
                  ->comment('IRT: Daya beda item (a-parameter). Kisaran normal: 0.5 - 2.5');
            $table->decimal('difficulty_b', 6, 4)->default(0.0000)->nullable()->after('discrimination_a')
                  ->comment('IRT: Tingkat kesulitan item (b-parameter). Kisaran normal: -3 sampai +3');

            // 6. Index untuk mempercepat query filter berdasarkan modul & sub_dimensi
            $table->index(['module', 'sub_dimension'], 'idx_questions_module_subdim');
            $table->index('is_reflective', 'idx_questions_is_reflective');
        });

        // =====================================================================
        // Backfill: Isi kolom baru berdasarkan data kolom lama (dimension + key)
        // Mapping: dimension/key lama → module/sub_dimension baru
        // =====================================================================

        // Map trait (key 0-4) → karakter + sub_dimensi
        $traitMap = [
            '0' => ['module' => 'karakter', 'sub_dimension' => 'openness'],
            '1' => ['module' => 'karakter', 'sub_dimension' => 'conscientiousness'],
            '2' => ['module' => 'karakter', 'sub_dimension' => 'extraversion'],
            '3' => ['module' => 'karakter', 'sub_dimension' => 'agreeableness'],
            '4' => ['module' => 'karakter', 'sub_dimension' => 'emotional_stability'],
        ];
        foreach ($traitMap as $key => $values) {
            DB::table('questions')
                ->where('dimension', 'trait')
                ->where('key', $key)
                ->update([
                    'module'        => $values['module'],
                    'sub_dimension' => $values['sub_dimension'],
                    'is_reflective' => DB::raw('CASE WHEN weight < 0 THEN 1 ELSE 0 END'),
                ]);
        }

        // Map riasec (key 0-5) → minat + sub_dimensi
        $riasecMap = [
            '0' => ['module' => 'minat', 'sub_dimension' => 'realistic'],
            '1' => ['module' => 'minat', 'sub_dimension' => 'investigative'],
            '2' => ['module' => 'minat', 'sub_dimension' => 'artistic'],
            '3' => ['module' => 'minat', 'sub_dimension' => 'social'],
            '4' => ['module' => 'minat', 'sub_dimension' => 'enterprising'],
            '5' => ['module' => 'minat', 'sub_dimension' => 'conventional'],
        ];
        foreach ($riasecMap as $key => $values) {
            DB::table('questions')
                ->where('dimension', 'riasec')
                ->where('key', $key)
                ->update([
                    'module'        => $values['module'],
                    'sub_dimension' => $values['sub_dimension'],
                    'is_reflective' => DB::raw('CASE WHEN weight < 0 THEN 1 ELSE 0 END'),
                ]);
        }

        // Map work_values (key 0-5) → nilai_kerja + sub_dimensi
        $workValuesMap = [
            '0' => ['module' => 'nilai_kerja', 'sub_dimension' => 'stabilitas_keamanan'],
            '1' => ['module' => 'nilai_kerja', 'sub_dimension' => 'prestasi_pengakuan'],
            '2' => ['module' => 'nilai_kerja', 'sub_dimension' => 'pelayanan_sosial'],
            '3' => ['module' => 'nilai_kerja', 'sub_dimension' => 'kemandirian_fleksibilitas'],
            '4' => ['module' => 'nilai_kerja', 'sub_dimension' => 'kreativitas_inovasi'],
            '5' => ['module' => 'nilai_kerja', 'sub_dimension' => 'keseimbangan_hidup'],
        ];
        foreach ($workValuesMap as $key => $values) {
            DB::table('questions')
                ->where('dimension', 'work_values')
                ->where('key', $key)
                ->update([
                    'module'        => $values['module'],
                    'sub_dimension' => $values['sub_dimension'],
                    'is_reflective' => false,
                ]);
        }

        // Map environment_pref (key 0-5) → preferensi_lingkungan + sub_dimensi
        $envPrefMap = [
            '0' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'struktur_fleksibilitas'],
            '1' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'individu_kolaboratif'],
            '2' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'stabil_dinamis'],
            '3' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'tekanan_rendah_tinggi'],
            '4' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'formal_santai'],
            '5' => ['module' => 'preferensi_lingkungan', 'sub_dimension' => 'lapangan_ruang_tertutup'],
        ];
        foreach ($envPrefMap as $key => $values) {
            DB::table('questions')
                ->where('dimension', 'environment_pref')
                ->where('key', $key)
                ->update([
                    'module'        => $values['module'],
                    'sub_dimension' => $values['sub_dimension'],
                    'is_reflective' => false,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex('idx_questions_module_subdim');
            $table->dropIndex('idx_questions_is_reflective');
            $table->dropColumn([
                'module',
                'sub_dimension',
                'is_reflective',
                'display_order',
                'discrimination_a',
                'difficulty_b',
            ]);
        });
    }
};
