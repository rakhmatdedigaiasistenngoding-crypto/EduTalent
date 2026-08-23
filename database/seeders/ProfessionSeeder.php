<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Jalankan seed database dengan standar V10 (5-6-6-6).
     * Urutan Array:
     * - Trait (5): Openness, Conscientiousness, Extraversion, Agreeableness, Emotional Stability
     * - RIASEC (6): Realistic, Investigative, Artistic, Social, Enterprising, Conventional
     * - Work Values (6): Stabilitas/Keamanan, Prestasi/Pengakuan, Pelayanan Sosial, Kemandirian, Kreativitas, Keseimbangan Hidup
     * - Environment (6): Struktur/Fleksibel, Individu/Kolaboratif, Stabil/Dinamis, Tekanan Rendah/Tinggi, Formal/Santai, Lapangan/Ruangan
     */
    public function run(): void
    {
        $now = now();

        // Bersihkan data lama
        DB::table('professions')->truncate();

        DB::table('professions')->insert([
            [
                'name' => 'Software Engineer',
                'domain' => 'Teknologi, Teknik & Sistem',
                'trait' => json_encode([0.9, 0.9, 0.4, 0.6, 0.8]), 
                'riasec' => json_encode([0.3, 0.9, 0.5, 0.2, 0.5, 0.8]),
                'work_values' => json_encode([0.8, 0.9, 0.4, 0.9, 0.9, 0.7]),
                'environment' => json_encode([0.2, 0.7, 0.8, 0.8, 0.3, 0.2]),
                'metadata' => json_encode([
                    'salary' => '8jt - 35jt',
                    'description' => 'Membangun dan memelihara sistem perangkat lunak yang kompleks untuk kebutuhan bisnis dan teknologi.',
                    'education' => 'S1 Teknik Informatika / Sistem Informasi',
                    'key_skills' => ['Pemrograman (Python/Java/JS)', 'Desain Algoritma', 'Pengujian & Debugging'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Data Analyst',
                'domain' => 'Bisnis, Manajemen & Administrasi',
                'trait' => json_encode([0.8, 0.95, 0.3, 0.5, 0.85]),
                'riasec' => json_encode([0.1, 0.95, 0.2, 0.2, 0.4, 0.95]),
                'work_values' => json_encode([0.9, 0.9, 0.3, 0.6, 0.6, 0.8]),
                'environment' => json_encode([0.1, 0.5, 0.6, 0.7, 0.2, 0.1]),
                'metadata' => json_encode([
                    'salary' => '7jt - 25jt',
                    'description' => 'Mengolah dan menginterpretasikan data mentah menjadi informasi berharga untuk mendukung pengambilan keputusan bisnis.',
                    'education' => 'S1 Statistika / Matematika / Informatika',
                    'key_skills' => ['Analisis Data (SQL/Python)', 'Visualisasi Data', 'Statistical Thinking'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Dokter Bedah',
                'domain' => 'Kesehatan & Perawatan',
                'trait' => json_encode([0.7, 0.98, 0.6, 0.7, 0.98]),
                'riasec' => json_encode([0.7, 0.95, 0.1, 0.8, 0.4, 0.9]),
                'work_values' => json_encode([0.8, 0.95, 0.95, 0.4, 0.3, 0.4]),
                'environment' => json_encode([0.1, 0.9, 0.9, 0.95, 0.1, 0.1]),
                'metadata' => json_encode([
                    'salary' => '20jt - 80jt',
                    'description' => 'Melakukan tindakan medis pembedahan yang kompleks untuk menyelamatkan nyawa dan meningkatkan kualitas hidup pasien.',
                    'education' => 'Spesialis Bedah',
                    'key_skills' => ['Ketelitian Klinis Tinggi', 'Ketahanan Mental', 'Koordinasi Tangan-Mata'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Graphic Designer',
                'domain' => 'Seni, Desain & Industri Kreatif',
                'trait' => json_encode([0.98, 0.8, 0.6, 0.7, 0.6]),
                'riasec' => json_encode([0.2, 0.4, 0.98, 0.3, 0.4, 0.6]),
                'work_values' => json_encode([0.4, 0.8, 0.5, 0.9, 0.98, 0.8]),
                'environment' => json_encode([0.8, 0.4, 0.7, 0.6, 0.8, 0.2]),
                'metadata' => json_encode([
                    'salary' => '5jt - 15jt',
                    'description' => 'Menciptakan konsep visual yang kuat untuk mengomunikasikan pesan, membangun identitas merek, dan menarik perhatian audiens.',
                    'education' => 'S1 Desain Komunikasi Visual',
                    'key_skills' => ['Adobe Creative Suite', 'Typography & Layout', 'Brand Identity Design'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Diplomat',
                'domain' => 'ASN & Pelayanan Publik',
                'trait' => json_encode([0.85, 0.9, 0.95, 0.9, 0.9]),
                'riasec' => json_encode([0.1, 0.6, 0.4, 0.95, 0.9, 0.8]),
                'work_values' => json_encode([0.8, 0.8, 0.9, 0.5, 0.4, 0.5]),
                'environment' => json_encode([0.2, 0.95, 0.9, 0.8, 0.1, 0.3]),
                'metadata' => json_encode([
                    'salary' => '10jt - 40jt',
                    'description' => 'Mewakili dan memperjuangkan kepentingan negara di forum dan lembaga internasional melalui negosiasi dan diplomasi.',
                    'education' => 'S1 Hubungan Internasional / Hukum',
                    'key_skills' => ['Negosiasi Lintas Budaya', 'Komunikasi Diplomatik', 'Analisis Kebijakan Luar Negeri'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Chef de Cuisine',
                'domain' => 'Pariwisata & Hospitality',
                'trait' => json_encode([0.8, 0.95, 0.8, 0.6, 0.8]),
                'riasec' => json_encode([0.9, 0.3, 0.8, 0.5, 0.9, 0.8]),
                'work_values' => json_encode([0.6, 0.95, 0.4, 0.7, 0.9, 0.3]),
                'environment' => json_encode([0.2, 0.95, 0.95, 0.98, 0.5, 0.2]),
                'metadata' => json_encode([
                    'salary' => '8jt - 30jt',
                    'description' => 'Memimpin dapur profesional, menciptakan menu inovatif, dan memastikan standar kualitas kuliner tertinggi.',
                    'education' => 'Diploma/S1 Tata Boga',
                    'key_skills' => ['Teknik Memasak Lanjutan', 'Manajemen Dapur', 'Kreativitas Kuliner'],
                ]),
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);
    }
}
