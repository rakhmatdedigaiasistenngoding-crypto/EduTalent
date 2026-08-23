<?php

namespace App\Services;

use App\Models\Profession;

class EngineService
{
    /**
     * Cache lokal untuk data profesi, diindeks per domain.
     */
    private static array $professionsCache = [];

    /**
     * Tabel Bobot GAP Profile Matching (Scale 1-5)
     * Mengikuti standar umum SPK Profile Matching.
     */
    private array $gapWeights = [
        0  => 5.0,  // Kompetensi sesuai
        1  => 4.5,  // Kelebihan 1 tingkat
        -1 => 4.0,  // Kekurangan 1 tingkat
        2  => 3.5,  // Kelebihan 2 tingkat
        -2 => 3.0,  // Kekurangan 2 tingkat
        3  => 2.5,  // Kelebihan 3 tingkat
        -3 => 2.0,  // Kekurangan 3 tingkat
        4  => 1.5,  // Kelebihan 4 tingkat
        -4 => 1.0,  // Kekurangan 4 tingkat
    ];

    /**
     * Jalankan engine hibrida PM-SAW (V10.0)
     */
    public function run(array $user, ?int $limit = 3): array
    {
        // 1. Ambil data profesi (domain-aware cache)
        $domainKey = !empty($user['domain']) ? $user['domain'] : '_all';

        if (!array_key_exists($domainKey, self::$professionsCache)) {
            $query = Profession::query();
            if ($domainKey !== '_all') {
                $exists = (clone $query)->where('domain', $user['domain'])->exists();
                if ($exists) {
                    $query->where('domain', $user['domain']);
                }
            }
            self::$professionsCache[$domainKey] = $query->get();
        }

        $professions = self::$professionsCache[$domainKey];
        $results = [];

        foreach ($professions as $profession) {
            $targetTrait = $profession->trait ?? [];
            $targetRiasec = $profession->riasec ?? [];
            $targetEnv = $profession->environment ?? [];
            $targetWorkValues = $profession->work_values ?? [];

            // ==========================================
            // TAHAP 1: PROFILE MATCHING (Bobot 70%)
            // Mengukur kecocokan Indikator Kritis (Hard/Soft Skill)
            // ==========================================
            
            // Core Factor (CF) = Minat (RIASEC) - Sangat Krusial
            $ncf = $this->calculateProfileMatching($user['riasec'] ?? [], $targetRiasec);
            
            // Secondary Factor (SF) = Karakter (Big Five) - Pendukung
            $nsf = $this->calculateProfileMatching($user['trait'] ?? [], $targetTrait);
            
            // Perhitungan PM (60% CF + 40% SF)
            $pmScore = (0.6 * $ncf) + (0.4 * $nsf); // Skala 1 - 5
            
            // Normalisasi PM ke skala 0 - 1 untuk digabungkan dengan SAW
            $pmScoreNormalized = $pmScore / 5.0;

            // ==========================================
            // TAHAP 2: SAW (Bobot 30%)
            // Mengukur kecocokan Indikator Informatif (Lingkungan & Nilai Kerja)
            // ==========================================
            
            // Asumsi bobot kriteria SAW terbagi rata (50% Env, 50% Work Values)
            $envSim = $this->calculateSAW($user['environment'] ?? [], $targetEnv);
            $wvSim = $this->calculateSAW($user['work_values'] ?? [], $targetWorkValues);
            
            $sawScore = (0.5 * $envSim) + (0.5 * $wvSim); // Skala 0 - 1

            // ==========================================
            // TAHAP 3: FINAL SCORE HYBRID
            // ==========================================
            
            $finalScore = (0.7 * $pmScoreNormalized) + (0.3 * $sawScore);

            $results[] = [
                'id'         => $profession->id,
                'name'       => $profession->name,
                'profession' => $profession->name,  // alias agar kompatibel dengan template PDF
                'domain'     => $profession->domain ?? ($profession->metadata['domain'] ?? '-'),
                'score'      => round($finalScore * 100, 2), // Skala 0-100 (%)
                'details'    => [
                    'pm_score'  => round($pmScoreNormalized * 100, 2),
                    'saw_score' => round($sawScore * 100, 2),
                    'ncf_raw'   => round($ncf, 2),
                    'nsf_raw'   => round($nsf, 2),
                ],
                'metadata'   => $profession->metadata,
            ];
        }

        // Urutkan berdasarkan score tertinggi
        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        if (!is_null($limit)) {
            $results = array_slice($results, 0, $limit);
        }

        return [
            'status' => 'success',
            'limit' => $limit,
            'algorithm' => 'PM-SAW (Hybrid v10)',
            'results' => $results
        ];
    }

    /**
     * Profile Matching: Hitung kecocokan menggunakan GAP Method.
     * Mengembalikan nilai skala 1-5.
     */
    private function calculateProfileMatching(array $user, array $target): float
    {
        if (empty($user) || empty($target)) return 0.0;

        $weights = [];
        foreach ($user as $i => $uVal) {
            $tVal = $target[$i] ?? 0;
            
            // 1. Proyeksikan nilai (0.0 - 1.0) ke skala (1 - 5)
            // Contoh: 1.0 -> 5, 0.0 -> 1, 0.5 -> 3
            $uScale = round(($uVal * 4) + 1);
            $tScale = round(($tVal * 4) + 1);
            
            // 2. Hitung Gap (Selisih)
            $gap = $uScale - $tScale;
            
            // 3. Konversi Gap ke Bobot berdasarkan tabel standar
            // Fallback ke 1.0 jika gap di luar batas ekstrem (>4 atau <-4)
            $weight = $this->gapWeights[$gap] ?? 1.0;
            $weights[] = $weight;
        }

        if (empty($weights)) return 0.0;
        
        // Rata-rata bobot (Mean)
        return array_sum($weights) / count($weights);
    }

    /**
     * Simple Additive Weighting (SAW): Hitung kedekatan (Similarity).
     * Karena input sudah pre-normalized (0-1), langsung hitung similarity absolut.
     * Mengembalikan nilai skala 0-1.
     */
    private function calculateSAW(array $user, array $target): float
    {
        if (empty($user) || empty($target)) return 0.0;

        $similarity = [];
        foreach ($user as $i => $val) {
            $similarity[] = 1 - abs($val - ($target[$i] ?? 0));
        }
        
        if (empty($similarity)) return 0.0;

        return array_sum($similarity) / count($similarity);
    }
}
