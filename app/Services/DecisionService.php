<?php

namespace App\Services;

class DecisionService
{
    /**
     * Menghitung skor keputusan terpadu (Decision Score) dengan preferensi user.
     * [STEP-35C]
     *
     * @param array $recommendation Data rekomendasi dari engine (berisi 'score')
     * @param float $stability Skor stabilitas dari PersonalProfileService (0-1)
     * @param string $preference 'stability' atau 'exploration'
     * @return float
     */
    public function calculateDecisionScore(array $recommendation, float $stability, string $preference = 'exploration'): float
    {
        // Engine returns score in 0-100%, but we need 0-1.0 scale to mix with stability
        $engineScore = ($recommendation['score'] ?? 0) / 100.0;
        
        // Mapping bobot stabilitas berdasarkan preferensi [STEP-35C]
        $stabilityWeight = match($preference) {
            'stability'   => 0.7,
            'exploration' => 0.3,
            default       => 0.3
        };

        $engineWeight = 1 - $stabilityWeight;
        
        // Rumus dinamis berdasarkan preferensi user
        $finalScore = ($engineScore * $engineWeight) + ($stability * $stabilityWeight);
        
        return round($finalScore, 4);
    }

    /**
     * Menghasilkan penjelasan rasional di balik skor keputusan.
     * [STEP-35D]
     *
     * @param array $prof Data profesi hasil re-ranking
     * @param float $stability Skor stabilitas user
     * @param string $preference Preferensi user saat ini
     * @return string
     */
    public function explainDecision(array $prof, float $stability, string $preference): string
    {
        $match = $prof['score'] ?? 0;
        
        // Skenario 1: Stabilitas Tinggi & Preferensi Stabilitas
        if ($stability >= 0.75 && $preference === 'stability') {
            return "Pilihan ini adalah yang paling aman dan bijak bagi Anda karena sangat selaras dengan pola karakter Anda yang sudah konsisten dan stabil di berbagai asesmen.";
        }

        // Skenario 2: Match Tinggi & Preferensi Eksplorasi
        if ($match >= 0.8 && $preference === 'exploration') {
            return "Sistem merekomendasikan ini sebagai prioritas karena menunjukkan kecocokan yang sangat tinggi dengan minat terbaru Anda, memberikan peluang eksplorasi yang menjanjikan.";
        }

        // Skenario 3: Stabilitas Rendah (Explorer)
        if ($stability < 0.5) {
            return "Meskipun karakter Anda masih berkembang (eksploratif), profesi ini memiliki keseimbangan terbaik untuk mendukung proses pencarian jati diri Anda saat ini.";
        }

        // Skenario 4: Default / Balanced
        return "Pilihan ini memiliki keseimbangan terbaik antara kecocokan teknis (Match) dan konsistensi profil Anda (Stability) untuk jangka panjang.";
    }

    /**
     * Menentukan tingkat keyakinan sistem berdasarkan skor akhir.
     * [STEP-35E]
     *
     * @param float $score Skor keputusan (0-1)
     * @return string
     */
    public function confidenceLevel(float $score): string
    {
        if ($score >= 0.8) return "Tinggi";
        if ($score >= 0.6) return "Cukup";
        return "Rendah";
    }
}
