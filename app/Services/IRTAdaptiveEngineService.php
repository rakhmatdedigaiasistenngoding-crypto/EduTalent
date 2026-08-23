<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * ===================================================================
 * FILE 2: IRTAdaptiveEngineService (Computerized Adaptive Testing)
 * ===================================================================
 *
 * TUJUAN:
 * Mengimplementasikan Computerized Adaptive Testing (CAT) berbasis
 * Item Response Theory (IRT) Model 2PL (Two-Parameter Logistic)
 * untuk fase FINAL asesmen. Engine ini secara cerdas memilih soal
 * berikutnya berdasarkan estimasi kemampuan/kecenderungan (Theta/θ)
 * pengguna saat itu.
 *
 * MENGAPA IRT LEBIH BAIK DARI CTT (Classical Test Theory)?
 * - CTT menganggap semua soal setara. IRT tidak.
 * - IRT menyadari setiap soal punya discriminasi (daya beda) dan
 *   kesulitan (difficulty) yang unik.
 * - Hasilnya (Theta) bersifat INVARIANT: tidak bergantung pada soal
 *   spesifik mana yang diberikan, berbeda dengan skor mentah CTT.
 *
 * MODEL IRT YANG DIGUNAKAN: 2PL (Two-Parameter Logistic)
 * ----------------------------------------------------------
 * P(θ) = 1 / (1 + exp(-1.702 * a * (θ - b)))
 *
 * Di mana:
 *   θ (theta)  = Estimasi kemampuan/kecenderungan laten pengguna
 *   a          = Discrimination parameter (daya beda item)
 *   b          = Difficulty parameter (tingkat kesulitan/ambang)
 *   1.702      = Konstanta skalasi agar model logistik ≈ model ogive normal
 *
 * ESTIMASI THETA: Newton-Raphson MLE (Maximum Likelihood Estimation)
 * ----------------------------------------------------------
 * MLE dipilih karena:
 * - Asymptotically efficient (akurat pada sampel besar)
 * - Tidak membutuhkan prior distribution (seperti EAP/MAP Bayesian)
 * - Konvergensi cepat dengan Newton-Raphson
 *
 * PEMILIHAN SOAL BERIKUTNYA: Maximum Fisher Information
 * ----------------------------------------------------------
 * I(θ) = (1.702 * a)² * P(θ) * (1 - P(θ))
 * Pilih soal dengan I(θ) tertinggi dari sisa bank soal.
 *
 * KONDISI PENGHENTIAN (Stopping Rules):
 * 1. Standard Error (SE) < 0.3 → Estimasi cukup akurat.
 * 2. Maksimal 30 soal telah dijawab.
 *
 * INTEGRASI KE PROYEK:
 * Gunakan service ini di route/controller baru untuk mode "Adaptive Test".
 * State CAT (jawaban + theta sementara) disimpan di Session atau Cache.
 *
 * @package App\Services
 */
class IRTAdaptiveEngineService
{
    // =========================================================================
    // KONFIGURASI ENGINE
    // =========================================================================

    /** Konstanta skalasi model logistik 2PL */
    private const SCALING_FACTOR = 1.702;

    /** Ambang batas Standard Error untuk penghentian otomatis */
    private const SE_THRESHOLD = 0.3;

    /** Jumlah soal maksimum yang boleh diberikan dalam satu sesi CAT */
    private const MAX_ITEMS = 30;

    /** Nilai theta awal sebelum ada jawaban (titik tengah skala) */
    private const THETA_INIT = 0.0;

    /** Batas atas dan bawah nilai theta untuk mencegah divergensi MLE */
    private const THETA_MIN = -4.0;
    private const THETA_MAX = 4.0;

    /** Jumlah iterasi maksimum Newton-Raphson */
    private const MLE_MAX_ITERATIONS = 50;

    /** Toleransi konvergensi Newton-Raphson */
    private const MLE_CONVERGENCE_TOL = 0.001;

    // =========================================================================
    // FUNGSI PUBLIK UTAMA
    // =========================================================================

    /**
     * Hitung estimasi Theta (θ) dari sekumpulan jawaban pengguna.
     *
     * Ini adalah fungsi INTI untuk menghitung kemampuan/kecenderungan
     * laten (trait) pengguna berdasarkan pola jawaban mereka.
     *
     * Metode: Newton-Raphson Maximum Likelihood Estimation (MLE).
     *
     * @param array $responses  Format: [['question_id' => X, 'score' => Y (1-5)], ...]
     * @param float $thetaInit  Nilai theta awal (default: 0.0).
     * @return array            ['theta' => float, 'se' => float, 'iterations' => int]
     *
     * Keterangan output:
     *   - theta: Estimasi kemampuan laten (-4 s/d +4). Positif = tinggi.
     *   - se:    Standard Error estimasi. Makin kecil = makin akurat.
     *   - iterations: Jumlah iterasi Newton-Raphson sampai konvergen.
     */
    public function calculateTheta(array $responses, float $thetaInit = self::THETA_INIT): array
    {
        // Jika belum ada jawaban, kembalikan nilai awal
        if (empty($responses)) {
            return [
                'theta'      => $thetaInit,
                'se'         => 999.0, // SE sangat besar = sangat tidak pasti
                'iterations' => 0,
            ];
        }

        // Ambil data soal yang dijawab dari database (sekali query)
        $questionIds = array_column($responses, 'question_id');
        $questions   = Question::whereIn('id', $questionIds)->get()->keyBy('id');

        // Konversi jawaban Likert (1-5) ke binary untuk model IRT
        // Skala 1-5 → 0 atau 1: jawaban ≥ 3 dianggap "setuju" (u=1)
        $binaryResponses = $this->convertToBinary($responses, $questions);

        // ---- Iterasi Newton-Raphson MLE ----
        $theta     = $thetaInit;
        $iteration = 0;

        for ($i = 0; $i < self::MLE_MAX_ITERATIONS; $i++) {
            $iteration++;

            // Hitung L'(θ) = First Derivative of Log-Likelihood
            $firstDerivative = $this->computeFirstDerivative($theta, $binaryResponses, $questions);

            // Hitung L''(θ) = Second Derivative (= -Fisher Information)
            $secondDerivative = $this->computeSecondDerivative($theta, $binaryResponses, $questions);

            // Proteksi division-by-zero jika second derivative mendekati 0
            if (abs($secondDerivative) < 1e-10) {
                Log::warning('[IRT MLE] Second derivative mendekati 0, iterasi dihentikan.', [
                    'theta'     => $theta,
                    'iteration' => $iteration,
                ]);
                break;
            }

            // Update theta: Newton-Raphson step
            // θ_new = θ_old - L'(θ) / L''(θ)
            $delta    = $firstDerivative / $secondDerivative;
            $thetaNew = $theta - $delta;

            // Clamp theta agar tidak keluar dari rentang valid
            $thetaNew = max(self::THETA_MIN, min(self::THETA_MAX, $thetaNew));

            // Cek konvergensi
            if (abs($thetaNew - $theta) < self::MLE_CONVERGENCE_TOL) {
                $theta = $thetaNew;
                break;
            }

            $theta = $thetaNew;
        }

        // ---- Hitung Standard Error ----
        // SE = 1 / sqrt(Fisher Information) = 1 / sqrt(-L''(θ_final))
        $fisherInfo = abs($this->computeSecondDerivative($theta, $binaryResponses, $questions));
        $se = ($fisherInfo > 0) ? (1.0 / sqrt($fisherInfo)) : 999.0;

        return [
            'theta'      => round($theta, 6),
            'se'         => round($se, 6),
            'iterations' => $iteration,
        ];
    }

    /**
     * Pilih soal berikutnya dari bank soal berbasis Fisher Information tertinggi.
     *
     * Algoritma:
     * 1. Keluarkan soal yang sudah pernah diberikan (answered IDs).
     * 2. Untuk setiap soal yang tersisa, hitung Fisher Information I(θ).
     * 3. Pilih soal dengan I(θ) tertinggi.
     *
     * @param float  $currentTheta  Estimasi θ pengguna saat ini.
     * @param array  $answeredIds   ID soal yang sudah dijawab (exclude list).
     * @param string|null $module   Filter per modul (opsional, untuk mode modul-spesifik).
     * @return Question|null        Soal berikutnya, atau null jika bank habis.
     */
    public function selectNextItem(
        float $currentTheta,
        array $answeredIds = [],
        ?string $module = null
    ): ?Question {
        // Query soal yang belum dijawab
        $query = Question::whereNotIn('id', $answeredIds)
            ->whereNotNull('discrimination_a') // Hanya soal yang sudah dikalibrasi
            ->whereNotNull('difficulty_b');

        // Filter per modul jika diminta
        if ($module !== null) {
            $query->where('module', $module);
        }

        // Ambil semua kandidat soal (hindari N+1 query di loop)
        $candidates = $query->get();

        if ($candidates->isEmpty()) {
            return null; // Bank soal habis
        }

        // Cari soal dengan Fisher Information tertinggi
        $bestItem       = null;
        $bestInfoValue  = -1.0;

        foreach ($candidates as $question) {
            $infoValue = $this->computeFisherInformation(
                theta: $currentTheta,
                a: (float) $question->discrimination_a,
                b: (float) $question->difficulty_b
            );

            if ($infoValue > $bestInfoValue) {
                $bestInfoValue = $infoValue;
                $bestItem      = $question;
            }
        }

        Log::info('[IRT CAT] Soal berikutnya dipilih.', [
            'selected_id'   => $bestItem?->id,
            'sub_dimension' => $bestItem?->sub_dimension,
            'fisher_info'   => round($bestInfoValue, 4),
            'current_theta' => $currentTheta,
        ]);

        return $bestItem;
    }

    /**
     * Cek apakah sesi CAT harus dihentikan.
     *
     * Kondisi penghentian (stopping rules):
     * 1. SE < SE_THRESHOLD (profil sudah cukup akurat), ATAU
     * 2. Jumlah soal yang dijawab sudah mencapai MAX_ITEMS.
     *
     * @param float $se             Standard Error estimasi theta saat ini.
     * @param int   $answeredCount  Jumlah soal yang sudah dijawab.
     * @return array                ['should_stop' => bool, 'reason' => string]
     */
    public function checkStoppingRule(float $se, int $answeredCount): array
    {
        // Kondisi 1: Presisi sudah cukup
        if ($se < self::SE_THRESHOLD) {
            return [
                'should_stop' => true,
                'reason'      => sprintf(
                    'SE (%.4f) sudah di bawah threshold (%.2f). Profil pengguna cukup akurat.',
                    $se,
                    self::SE_THRESHOLD
                ),
            ];
        }

        // Kondisi 2: Batas maksimum soal tercapai
        if ($answeredCount >= self::MAX_ITEMS) {
            return [
                'should_stop' => true,
                'reason'      => sprintf(
                    'Batas maksimum %d soal telah tercapai.',
                    self::MAX_ITEMS
                ),
            ];
        }

        // Lanjutkan tes
        return [
            'should_stop' => false,
            'reason'      => sprintf(
                'Lanjut: SE=%.4f (threshold=%.2f), item=%d/%d',
                $se,
                self::SE_THRESHOLD,
                $answeredCount,
                self::MAX_ITEMS
            ),
        ];
    }

    /**
     * Jalankan satu langkah sesi CAT secara lengkap.
     *
     * Fungsi ini mengorkestrasikan satu siklus penuh CAT:
     * 1. Hitung theta dari semua jawaban yang ada.
     * 2. Cek stopping rule.
     * 3. Jika lanjut, pilih soal berikutnya.
     *
     * @param array $responses   Array semua jawaban [['question_id'=>X, 'score'=>Y], ...]
     * @param string|null $module  Filter modul untuk soal berikutnya.
     * @return array  Status CAT lengkap.
     */
    public function runStep(array $responses, ?string $module = null): array
    {
        $answeredCount = count($responses);
        $answeredIds   = array_column($responses, 'question_id');

        // 1. Estimasi theta berdasarkan jawaban yang ada
        $estimation = $this->calculateTheta($responses);
        $theta      = $estimation['theta'];
        $se         = $estimation['se'];

        // 2. Cek stopping rule
        $stopping = $this->checkStoppingRule($se, $answeredCount);

        if ($stopping['should_stop']) {
            return [
                'status'        => 'completed',
                'reason'        => $stopping['reason'],
                'theta'         => $theta,
                'se'            => $se,
                'answered_count'=> $answeredCount,
                'next_item'     => null,
            ];
        }

        // 3. Pilih soal berikutnya
        $nextItem = $this->selectNextItem($theta, $answeredIds, $module);

        if ($nextItem === null) {
            return [
                'status'        => 'completed',
                'reason'        => 'Bank soal habis.',
                'theta'         => $theta,
                'se'            => $se,
                'answered_count'=> $answeredCount,
                'next_item'     => null,
            ];
        }

        return [
            'status'        => 'continue',
            'reason'        => $stopping['reason'],
            'theta'         => $theta,
            'se'            => $se,
            'answered_count'=> $answeredCount,
            'next_item'     => [
                'id'            => $nextItem->id,
                'text'          => $nextItem->text,
                'module'        => $nextItem->module,
                'sub_dimension' => $nextItem->sub_dimension,
                'is_reflective' => $nextItem->is_reflective,
                'discrimination_a' => $nextItem->discrimination_a,
                'difficulty_b'  => $nextItem->difficulty_b,
            ],
        ];
    }

    // =========================================================================
    // FUNGSI PRIVAT: MATEMATIKA IRT
    // =========================================================================

    /**
     * Model IRT 2PL: Probabilitas menjawab "setuju" (u=1) pada item i.
     *
     * Formula: P(θ) = 1 / (1 + exp(-D * a * (θ - b)))
     *
     * @param float $theta  Estimasi kemampuan laten pengguna.
     * @param float $a      Discrimination parameter item.
     * @param float $b      Difficulty parameter item.
     * @return float        Probabilitas P ∈ [0, 1].
     */
    private function computeProbability(float $theta, float $a, float $b): float
    {
        $exponent = -self::SCALING_FACTOR * $a * ($theta - $b);
        return 1.0 / (1.0 + exp($exponent));
    }

    /**
     * Fisher Information untuk satu item pada theta tertentu.
     *
     * Formula: I(θ) = (D * a)² * P(θ) * (1 - P(θ))
     *
     * Makin tinggi I(θ), makin informatif soal tersebut di titik theta tsb.
     * Maksimum terjadi ketika P(θ) = 0.5, yaitu saat θ = b.
     *
     * @param float $theta  Estimasi kemampuan laten.
     * @param float $a      Discrimination parameter.
     * @param float $b      Difficulty parameter.
     * @return float        Nilai informasi Fisher.
     */
    private function computeFisherInformation(float $theta, float $a, float $b): float
    {
        $p = $this->computeProbability($theta, $a, $b);
        $q = 1.0 - $p; // P(salah/tidak setuju)
        return pow(self::SCALING_FACTOR * $a, 2) * $p * $q;
    }

    /**
     * Hitung turunan pertama Log-Likelihood terhadap theta.
     *
     * L'(θ) = Σ D*a*(u_i - P_i(θ))
     *
     * Di mana u_i = respons binary pengguna (0 atau 1) pada item i.
     *
     * @param float      $theta          Nilai theta saat ini.
     * @param array      $binaryResponses Array [question_id => 0|1].
     * @param Collection $questions      Koleksi objek Question.
     * @return float                     Nilai turunan pertama.
     */
    private function computeFirstDerivative(
        float $theta,
        array $binaryResponses,
        Collection $questions
    ): float {
        $derivative = 0.0;

        foreach ($binaryResponses as $questionId => $u) {
            $question = $questions->get($questionId);
            if (!$question) continue;

            $a = (float) ($question->discrimination_a ?? 1.0);
            $b = (float) ($question->difficulty_b ?? 0.0);
            $p = $this->computeProbability($theta, $a, $b);

            // Kontribusi item i terhadap L'(θ)
            $derivative += self::SCALING_FACTOR * $a * ($u - $p);
        }

        return $derivative;
    }

    /**
     * Hitung turunan kedua Log-Likelihood terhadap theta.
     *
     * L''(θ) = -Σ (D*a)² * P_i(θ) * Q_i(θ)
     *        = -Σ Fisher Information per item
     *        = -(Total Fisher Information)
     *
     * @param float      $theta          Nilai theta saat ini.
     * @param array      $binaryResponses Array [question_id => 0|1].
     * @param Collection $questions      Koleksi objek Question.
     * @return float                     Nilai turunan kedua (negatif).
     */
    private function computeSecondDerivative(
        float $theta,
        array $binaryResponses,
        Collection $questions
    ): float {
        $derivative = 0.0;

        foreach ($binaryResponses as $questionId => $u) {
            $question = $questions->get($questionId);
            if (!$question) continue;

            $a = (float) ($question->discrimination_a ?? 1.0);
            $b = (float) ($question->difficulty_b ?? 0.0);

            // Kontribusi item i terhadap L''(θ) = -I_i(θ)
            $derivative -= $this->computeFisherInformation($theta, $a, $b);
        }

        return $derivative;
    }

    /**
     * Konversi jawaban Likert (1-5) ke binary (0/1) untuk model IRT.
     *
     * Konvensi yang digunakan:
     * - Soal POSITIF (is_reflective = false):
     *   Skor ≥ 3 → u = 1 (setuju/tinggi), skor < 3 → u = 0.
     * - Soal REFLEKTIF (is_reflective = true):
     *   Skor DIBALIK dulu: score_efektif = 6 - score_asli.
     *   Kemudian: score_efektif ≥ 3 → u = 1, score_efektif < 3 → u = 0.
     *
     * @param array      $responses  Array [['question_id' => X, 'score' => Y]].
     * @param Collection $questions  Koleksi objek Question.
     * @return array                 Array [question_id => 0|1].
     */
    private function convertToBinary(array $responses, Collection $questions): array
    {
        $binary = [];

        foreach ($responses as $response) {
            $questionId = $response['question_id'];
            $score      = (int) ($response['score'] ?? 3);
            $question   = $questions->get($questionId);

            if (!$question) continue;

            // Reverse-scoring untuk item reflektif
            if ($question->is_reflective) {
                $score = 6 - $score; // Balik: 1→5, 2→4, 3→3, 4→2, 5→1
            }

            // Binarisasi: threshold di tengah skala Likert (skor ≥ 3 = setuju)
            $binary[$questionId] = ($score >= 3) ? 1 : 0;
        }

        return $binary;
    }
}
