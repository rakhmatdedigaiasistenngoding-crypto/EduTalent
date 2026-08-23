<?php

namespace App\Services;

use App\Models\Question;

class ScoringService
{
    /**
     * Mengonversi jawaban kuesioner (1-5) menjadi vector yang dibutuhkan EngineService.
     * 
     * @param array $answers Format: [question_id => score, ...]
     * @return array [trait => [...], riasec => [...], environment => [...]]
     */
    public function mapAnswersToVectors(array $answers): array
    {
        // 1. Ambil semua pertanyaan yang dijawab
        $questionIds = array_keys($answers);
        $questions = Question::whereIn('id', $questionIds)->get();

        // 2. Inisialisasi struktur vector default sesuai jumlah sub-dimensi
        // trait: 5 (Big Five), riasec: 6, environment: 6, work_values: 6
        $vectors = [
            'trait'       => array_fill(0, 5, []),
            'riasec'      => array_fill(0, 6, []),
            'environment' => array_fill(0, 6, []),
            'work_values' => array_fill(0, 6, [])
        ];

        // 3. Kelompokkan jawaban berdasarkan dimensi dan key (index)
        foreach ($questions as $question) {
            $score = (float) ($answers[$question->id] ?? 0);
            
            // Handle Reverse Scoring untuk item reflektif
            if ($question->is_reflective) {
                $score = 6.0 - $score; // 1->5, 2->4, 3->3, 4->2, 5->1
            }

            $dim = $question->dimension;
            $key = (int) $question->key;

            if (isset($vectors[$dim][$key])) {
                $vectors[$dim][$key][] = $score;
            }
        }

        // 4. Hitung rata-rata untuk setiap index
        foreach ($vectors as $dim => $keys) {
            foreach ($keys as $index => $scores) {
                if (empty($scores)) {
                    $vectors[$dim][$index] = 0.0;
                } else {
                    $avg = array_sum($scores) / count($scores);
                    $vectors[$dim][$index] = ($avg - 1) / 4; // Normalize 1-5 to 0.0-1.0 scale
                }
            }
        }

        return $vectors;
    }

    /**
     * Mengecek konsistensi jawaban (Consistency Checker).
     * Mendeteksi jika user menjawab 'Sangat Sesuai' (5) pada item positif 
     * DAN 'Sangat Sesuai' (5) pada item reflektif di dimensi yang sama.
     * 
     * @param array $answers [question_id => score]
     * @return array ['is_consistent' => bool, 'error_rate' => float, 'flags' => array]
     */
    public function checkConsistency(array $answers): array
    {
        $questionIds = array_keys($answers);
        $questions = Question::whereIn('id', $questionIds)->get()->groupBy(['module', 'sub_dimension']);
        
        $violations = 0;
        $checkedPairs = 0;
        $flags = [];

        foreach ($questions as $module => $subDims) {
            foreach ($subDims as $subDim => $items) {
                $posItems = $items->where('is_reflective', false);
                $refItems = $items->where('is_reflective', true);

                if ($posItems->count() > 0 && $refItems->count() > 0) {
                    foreach ($posItems as $p) {
                        foreach ($refItems as $r) {
                            $pScore = (int) ($answers[$p->id] ?? 0);
                            $rScore = (int) ($answers[$r->id] ?? 0);

                            // Jika keduanya Sangat Sesuai (5) atau Sesuai (4), ini kontradiksi berat
                            if ($pScore >= 4 && $rScore >= 4) {
                                $violations++;
                                $flags[] = "Kontradiksi di {$module} - {$subDim}: Positive({$pScore}) vs Reflective({$rScore})";
                            }
                            $checkedPairs++;
                        }
                    }
                }
            }
        }

        $errorRate = $checkedPairs > 0 ? ($violations / $checkedPairs) : 0;
        
        return [
            'is_consistent' => $errorRate < 0.15, // Threshold 15% error
            'error_rate'    => $errorRate,
            'violations'    => $violations,
            'flags'         => $flags
        ];
    }

    /**
     * Mengecek validitas jawaban untuk mendeteksi pola asal-asalan (Random Answering).
     * 
     * @param array $answers [question_id => score]
     * @return array ['is_valid' => bool, 'reason' => string]
     */
    public function checkValidity(array $answers): array
    {
        $totalAnswers = count($answers);
        if ($totalAnswers === 0) {
            return ['is_valid' => false, 'reason' => 'Tidak ada jawaban yang diberikan.'];
        }

        // Cast all values to int (answers come as strings from JSON)
        $intAnswers = array_map('intval', $answers);
        $scoreCounts = array_count_values($intAnswers);
        
        // 1. Central Tendency Bias (Terlalu banyak memilih netral '3')
        $neutralCount = $scoreCounts[3] ?? 0;
        $neutralRate = $neutralCount / $totalAnswers;
        if ($neutralRate >= 0.70) {
            return ['is_valid' => false, 'reason' => 'Pola jawaban terdeteksi asal-asalan (Terlalu banyak memilih "Biasa Saja").'];
        }

        // 2. Extreme Response Bias (Terlalu banyak memilih '1' atau '5')
        $extremeCount = ($scoreCounts[1] ?? 0) + ($scoreCounts[5] ?? 0);
        $extremeRate = $extremeCount / $totalAnswers;
        if ($extremeRate >= 0.85) {
            return ['is_valid' => false, 'reason' => 'Pola jawaban terdeteksi ekstrem (Hanya memilih "Sangat Sesuai" atau "Sangat Tidak Sesuai").'];
        }
        
        // 3. Acquiescence Bias (Menyetujui semua hal, '4' atau '5')
        $agreeCount = ($scoreCounts[4] ?? 0) + ($scoreCounts[5] ?? 0);
        $agreeRate = $agreeCount / $totalAnswers;
        if ($agreeRate >= 0.95) {
             return ['is_valid' => false, 'reason' => 'Terlalu banyak menyetujui tanpa mempertimbangkan kelemahan diri secara objektif.'];
        }

        // 4. Variance Check: Semua jawaban identik (satu nilai diulang terus)
        $uniqueValues = count(array_unique($intAnswers));
        if ($uniqueValues <= 1) {
            return ['is_valid' => false, 'reason' => 'Semua jawaban identik. Isi asesmen dengan jujur sesuai kepribadian Anda.'];
        }

        return ['is_valid' => true, 'reason' => 'Valid'];
    }
}
