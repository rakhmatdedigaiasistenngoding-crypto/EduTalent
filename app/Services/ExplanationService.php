<?php

namespace App\Services;

use App\Models\AssessmentResult;

class ExplanationService
{
    /**
     * Generate penjelasan mengapa profesi tertentu cocok dengan profil user.
     * 
     * @param AssessmentResult $result
     * @param array $profession Data profesi dari result_top_n
     * @return array
     */
    public function generate($result, $profession)
    {
        $explanations = [];

        // Ambil data input dari model AssessmentResult
        $trait = $result->input_trait ?? [];
        $riasec = $result->input_riasec ?? [];
        $environment = $result->input_environment ?? [];

        // Mapping Label (Source: QuestionSeeder mapping)
        $traitLabels = [
            '0' => 'Openness',
            '1' => 'Conscientiousness',
            '2' => 'Extraversion',
            '3' => 'Agreeableness',
            '4' => 'Emotional Stability',
        ];

        $riasecLabels = [
            '0' => 'Realistic',
            '1' => 'Investigative',
            '2' => 'Artistic',
            '3' => 'Social',
            '4' => 'Enterprising',
            '5' => 'Conventional',
        ];

        $envLabels = [
            '0' => 'Terstruktur',
            '1' => 'Kolaboratif',
            '2' => 'Dinamis',
            '3' => 'High Pressure',
            '4' => 'Formal',
            '5' => 'Outdoor',
        ];

        // 1. Trait tertinggi
        if (!empty($trait)) {
            $topTraitKey = array_keys($trait, max($trait))[0];
            $label = $traitLabels[$topTraitKey] ?? ucfirst($topTraitKey);
            $explanations[] = "Anda memiliki kecenderungan **" . $label . "** yang tinggi";
        }

        // 2. RIASEC tertinggi
        if (!empty($riasec)) {
            $topRiasecKey = array_keys($riasec, max($riasec))[0];
            $label = $riasecLabels[$topRiasecKey] ?? ucfirst($topRiasecKey);
            $explanations[] = "Minat Anda dominan pada kategori **" . $label . "**";
        }

        // 3. Environment tertinggi
        if (!empty($environment)) {
            $topEnvKey = array_keys($environment, max($environment))[0];
            $label = $envLabels[$topEnvKey] ?? ucfirst($topEnvKey);
            $explanations[] = "Anda cocok pada lingkungan **" . $label . "**";
        }

        return array_slice($explanations, 0, 3);
    }

    /**
     * Breakdown faktor yang paling mempengaruhi skor.
     * Mengambil bobot (weights) yang digunakan sistem saat menghitung hasil.
     * 
     * @param AssessmentResult $result
     * @param array $profession
     * @return array
     */
    public function breakdown($result, $profession)
    {
        // Prioritas 1: Ambil bobot asli yang tersimpan di model AssessmentResult
        if (!empty($result->weights)) {
            return $result->weights;
        }

        // Prioritas 2: Ambil dari config jika ada
        $configWeights = config('engine.weights');
        if (!empty($configWeights)) {
            return $configWeights;
        }

        // [FIX BUG-B] Fallback diselaraskan dengan default EngineService::resolveWeights()
        return [
            'trait'       => 0.5,
            'riasec'      => 0.3,
            'environment' => 0.2,
        ];
    }

    /**
     * Interpretasi skor numerik menjadi label kualitatif.
     * 
     * @param float $score (0.0 - 1.0)
     * @return string
     */
    public function interpretScore($score)
    {
        if ($score > 0.8) return "Sangat cocok";
        if ($score > 0.6) return "Cocok";
        if ($score > 0.4) return "Cukup cocok";
        
        return "Kurang cocok";
    }

    /**
     * Membandingkan dua profesi teratas.
     * 
     * @param array $top1
     * @param array|null $top2
     * @return string|null
     */
    public function compare($top1, $top2)
    {
        if (!$top2) {
            return null;
        }

        if (($top1['score'] ?? 0) > ($top2['score'] ?? 0)) {
            return "Pilihan ini lebih unggul dibanding alternatif karena skor keseluruhan lebih tinggi";
        }

        return null;
    }
}
