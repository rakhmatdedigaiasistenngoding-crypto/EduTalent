<?php

namespace App\Services;

class ScenarioService
{
    /**
     * Generate beberapa skenario alternatif berdasarkan hasil asesmen.
     * 
     * Menggunakan array data mentah (bukan object Eloquent) untuk menghindari
     * mutasi pada data asli dan memastikan keamanan komputasi.
     *
     * @param \App\Models\AssessmentResult $result
     * @return array
     */
    public function generateScenarios($result): array
    {
        // Validasi: pastikan semua field tersedia
        if (
            empty($result->input_trait) ||
            empty($result->input_riasec) ||
            empty($result->input_environment)
        ) {
            return [];
        }

        // --- Skenario 1: Baseline (kondisi saat ini) ---
        $baseline = [
            'label'       => 'Profil Anda saat ini',
            'description' => 'Gambaran berdasarkan hasil asesmen Anda saat ini.',
            'trait'       => $this->clampArray($result->input_trait),
            'riasec'      => $this->clampArray($result->input_riasec),
            'environment' => $this->clampArray($result->input_environment),
        ];

        // --- Skenario 2: Improved Top Trait (+10%) ---
        $traitCopy = $result->input_trait;
        arsort($traitCopy);
        $topTraitKey = key($traitCopy);

        $improvedTrait = $result->input_trait;
        $improvedTrait[$topTraitKey] = ($improvedTrait[$topTraitKey] ?? 0) + 0.1;

        $improvedScenario = [
            'label'       => 'Jika Anda mengembangkan kekuatan utama',
            'description' => "Simulasi jika aspek karakter terkuat Anda ({$topTraitKey}) meningkat 10% lebih.",
            'trait'       => $this->clampArray($improvedTrait),
            'riasec'      => $this->clampArray($result->input_riasec),
            'environment' => $this->clampArray($result->input_environment),
        ];

        // --- Skenario 3: Shift Interest (prioritas RIASEC dibalik) ---
        $shiftedRiasec = array_reverse($result->input_riasec, true);

        $shiftScenario = [
            'label'       => 'Jika minat Anda berubah',
            'description' => 'Simulasi jika Anda mengembangkan minat yang berlawanan dari saat ini.',
            'trait'       => $this->clampArray($result->input_trait),
            'riasec'      => $this->clampArray($shiftedRiasec),
            'environment' => $this->clampArray($result->input_environment),
        ];

        return [
            'current'        => $baseline,
            'improved_trait' => $improvedScenario,
            'shift_interest' => $shiftScenario,
        ];
    }

    /**
     * Hitung delta/perbedaan antar dua skenario untuk keperluan analitik.
     *
     * @param array $scenarioA
     * @param array $scenarioB
     * @return array
     */
    public function calculateDelta(array $scenarioA, array $scenarioB): array
    {
        $delta = [];

        foreach (['trait', 'riasec', 'environment'] as $dim) {
            $dimA = $scenarioA[$dim] ?? [];
            $dimB = $scenarioB[$dim] ?? [];

            foreach ($dimA as $key => $valA) {
                $valB = $dimB[$key] ?? 0;
                $delta[$dim][$key] = round(($valB - $valA) * 100, 1); // dalam persen
            }
        }

        return $delta;
    }

    /**
     * Memberikan insight naratif untuk setiap skenario simulasi.
     * [STEP-34E]
     *
     * @param string $key
     * @return string
     */
    public function scenarioInsight(string $key): string
    {
        return match($key) {
            'current' => "Ini adalah kondisi Anda saat ini",
            'improved_trait' => "Jika Anda mengembangkan kekuatan utama, peluang meningkat",
            'shift_interest' => "Perubahan minat dapat membuka jalur baru",
            default => ""
        };
    }

    /**
     * Memastikan semua nilai dalam array berada dalam rentang valid [0, 1].
     * [STEP-34F]
     *
     * @param array $data
     * @return array
     */
    private function clampArray(array $data): array
    {
        return array_map(function ($value) {
            return max(0, min(1, (float) $value));
        }, $data);
    }
}
