<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file JSON sumber (Source of Truth v10)
        $path = base_path('dokumen/gemini/ShiroAsesmen_QuestionBank_176.json');
        
        if (!File::exists($path)) {
            $this->command->error("File JSON tidak ditemukan di: {$path}");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if (is_null($data)) {
            $this->command->error("Format JSON tidak valid.");
            return;
        }

        // Bersihkan data lama
        Question::query()->delete();

        // Mapping Modul (v10) ke Dimension (Lama/Legacy)
        $legacyDimMap = [
            'karakter'               => 'trait',
            'minat'                  => 'riasec',
            'nilai_kerja'            => 'work_values',
            'preferensi_lingkungan'  => 'environment_pref',
        ];

        // Mapping Modul
        $moduleMap = [
            'Karakter (Big Five)'   => 'karakter',
            'Minat (RIASEC)'        => 'minat',
            'Nilai Kerja'           => 'nilai_kerja',
            'Preferensi Lingkungan' => 'preferensi_lingkungan',
        ];

        // Mapping Sub-Dimensi (v10) ke Key (Lama/Legacy)
        $legacyKeyMap = [
            // Karakter
            'openness'                  => '0',
            'conscientiousness'         => '1',
            'extraversion'              => '2',
            'agreeableness'             => '3',
            'emotional_stability'       => '4',
            
            // Minat (RIASEC)
            'realistic'                 => '0',
            'investigative'             => '1',
            'artistic'                  => '2',
            'social'                    => '3',
            'enterprising'              => '4',
            'conventional'              => '5',
            
            // Nilai Kerja
            'stabilitas_keamanan'       => '0',
            'prestasi_pengakuan'        => '1',
            'pelayanan_sosial'          => '2',
            'kemandirian_fleksibilitas' => '3',
            'kreativitas_inovasi'       => '4',
            'keseimbangan_hidup'        => '5',
            
            // Preferensi Lingkungan
            'struktur_fleksibilitas'    => '0',
            'individu_kolaboratif'      => '1',
            'stabil_dinamis'            => '2',
            'tekanan_rendah_tinggi'     => '3',
            'formal_santai'             => '4',
            'lapangan_ruang_tertutup'   => '5',
        ];

        // Mapping Sub-Dimensi (dari JSON ke Key internal v10)
        $subDimMap = [
            // Karakter
            'Extraversion'              => 'extraversion',
            'Agreeableness'             => 'agreeableness',
            'Conscientiousness'         => 'conscientiousness',
            'Emotional Stability'       => 'emotional_stability',
            'Openness'                  => 'openness',
            
            // Minat (RIASEC)
            'Realistic'                 => 'realistic',
            'Investigative'             => 'investigative',
            'Artistic'                  => 'artistic',
            'Social'                    => 'social',
            'Enterprising'              => 'enterprising',
            'Conventional'              => 'conventional',
            
            // Nilai Kerja
            'Kontribusi Sosial'         => 'pelayanan_sosial',
            'Stabilitas'                => 'stabilitas_keamanan',
            'Pencapaian'                => 'prestasi_pengakuan',
            'Otonomi'                   => 'kemandirian_fleksibilitas',
            'Kreativitas'               => 'kreativitas_inovasi',
            'Keseimbangan Hidup'        => 'keseimbangan_hidup',
            
            // Preferensi Lingkungan
            'Formal vs Santai'          => 'formal_santai',
            'Mandiri vs Kolaboratif'    => 'individu_kolaboratif',
            'Indoor vs Outdoor'         => 'lapangan_ruang_tertutup',
            'Statis vs Dinamis'         => 'stabil_dinamis',
            'Low vs High Pressure'      => 'tekanan_rendah_tinggi',
            'Teknis vs Komunikasi'      => 'struktur_fleksibilitas',
        ];

        $count = 0;
        foreach ($data as $item) {
            $module = $moduleMap[$item['modul']] ?? strtolower($item['modul']);
            $subDim = $subDimMap[$item['dimensi']] ?? strtolower(str_replace(' ', '_', $item['dimensi']));
            
            Question::create([
                'id'               => $item['id'],
                'module'           => $module,
                'sub_dimension'    => $subDim,
                'text'             => $item['soal'],
                'is_reflective'    => ($item['tipe'] === 'Reflektif'),
                'weight'           => ($item['tipe'] === 'Reflektif') ? -1.0 : 1.0,
                'display_order'    => $item['id'],
                
                // Backward Compatibility (Legacy Columns)
                'dimension'        => $legacyDimMap[$module] ?? 'trait',
                'key'              => $legacyKeyMap[$subDim] ?? '0',
                
                // Parameter IRT default
                'discrimination_a' => 1.0000,
                'difficulty_b'     => 0.0000,
            ]);
            $count++;
        }

        $this->command->info("Berhasil mengimpor {$count} butir soal dari JSON (Versi 10.0 + Legacy Fix).");
    }
}
