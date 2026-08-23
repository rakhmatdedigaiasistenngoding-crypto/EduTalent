<?php

namespace App\Services;

use App\Models\AssessmentResult;
use App\Models\Identity;

class PersonalProfileService
{
    /**
     * Cache lokal untuk menyimpan hasil resolusi identitas dalam satu request.
     */
    private array $resolvedIdsCache = [];

    /**
     * [FIX BUG-02] Resolusi semua Identity ID yang terkait dengan user/identity.
     * Menggabungkan identitas personal dan anonymous yang sudah di-link.
     */
    private function resolveIdentityIds(?int $userId, ?int $identityId): array
    {
        $cacheKey = "{$userId}_{$identityId}";
        if (isset($this->resolvedIdsCache[$cacheKey])) {
            return $this->resolvedIdsCache[$cacheKey];
        }

        $ids = [];

        // Prioritas 1: Cari identitas personal berdasarkan user_id
        if ($userId) {
            $identity = Identity::where('user_id', $userId)
                ->where('identity_type', Identity::TYPE_PERSONAL)
                ->first();

            if ($identity) {
                $ids = Identity::getLinkedIdentityIds($identity->id)->toArray();
            }
        }

        // Prioritas 2: Fallback ke identity_id langsung jika belum ada hasil
        if (empty($ids) && $identityId) {
            $ids = Identity::getLinkedIdentityIds($identityId)->toArray();
        }

        $this->resolvedIdsCache[$cacheKey] = $ids;
        return $ids;
    }

    /**
     * Agregasi profil user berdasarkan riwayat hasil asesmen.
     * Mengambil N hasil terakhir dan menghitung rata-rata skor per dimensi.
     * Menggunakan semua identitas terhubung (personal + anonymous yang di-link).
     *
     * @param int|null $userId
     * @param int|null $identityId
     * @param int $limit Jumlah tes terakhir yang akan diagregasi
     * @return array
     */
    public function aggregate(?int $userId = null, ?int $identityId = null, int $limit = 3): array
    {
        $identityIds = $this->resolveIdentityIds($userId, $identityId);

        if (empty($identityIds)) {
            return [];
        }

        // Ambil N hasil terakhir yang valid dari semua identitas terhubung
        $results = AssessmentResult::whereIn('identity_id', $identityIds)
            ->latest('created_at')
            ->take($limit)
            ->get();

        if ($results->isEmpty()) {
            return [];
        }

        // Jika data < 2, kembalikan hasil terakhir saja
        if ($results->count() < 2) {
            $latest = $results->first();
            return [
                'trait'       => $latest->input_trait,
                'riasec'      => $latest->input_riasec,
                'environment' => $latest->input_environment,
            ];
        }

        // Proses agregasi (Simple Average)
        $aggregated = ['trait' => [], 'riasec' => [], 'environment' => []];
        $counts     = ['trait' => [], 'riasec' => [], 'environment' => []];

        foreach ($results as $result) {
            $this->sumDimension($aggregated['trait'],       $counts['trait'],       $result->input_trait);
            $this->sumDimension($aggregated['riasec'],      $counts['riasec'],      $result->input_riasec);
            $this->sumDimension($aggregated['environment'], $counts['environment'], $result->input_environment);
        }

        return [
            'trait'       => $this->calculateAverage($aggregated['trait'],       $counts['trait']),
            'riasec'      => $this->calculateAverage($aggregated['riasec'],      $counts['riasec']),
            'environment' => $this->calculateAverage($aggregated['environment'], $counts['environment']),
        ];
    }

    /**
     * [FIX BUG-01 & BUG-02] Mendeteksi tren perubahan karakter user.
     * Membandingkan hasil asesmen pertama dengan yang terbaru.
     * Menggunakan query first/last terpisah — TIDAK memuat semua data ke memori.
     *
     * @param int|null $userId
     * @param int|null $identityId
     * @param float $threshold Batas minimal perubahan yang dianggap signifikan
     * @return array
     */
    public function detectTrend(?int $userId = null, ?int $identityId = null, float $threshold = 0.1): array
    {
        $empty = ['increase' => [], 'decrease' => []];

        $identityIds = $this->resolveIdentityIds($userId, $identityId);
        if (empty($identityIds)) {
            return $empty;
        }

        $baseQuery = AssessmentResult::whereIn('identity_id', $identityIds);

        // FIX BUG-01: Hanya ambil 2 record saja (pertama & terakhir), bukan semua
        $total = (clone $baseQuery)->count();
        if ($total < 2) {
            return $empty;
        }

        $first = (clone $baseQuery)->oldest('created_at')->first();
        $last  = (clone $baseQuery)->latest('created_at')->first();

        // Proteksi: Pastikan bukan record yang identik
        if (!$first || !$last || $first->id === $last->id) {
            return $empty;
        }

        $trends = ['increase' => [], 'decrease' => []];

        // Bandingkan dimensi Trait dan RIASEC
        foreach (['trait', 'riasec'] as $dim) {
            $firstDim = $dim === 'trait' ? $first->input_trait : $first->input_riasec;
            $lastDim  = $dim === 'trait' ? $last->input_trait  : $last->input_riasec;

            if (empty($firstDim) || empty($lastDim)) {
                continue;
            }

            foreach ($lastDim as $key => $value) {
                if (isset($firstDim[$key])) {
                    $diff = $value - $firstDim[$key];
                    if (abs($diff) >= $threshold) {
                        $item = [
                            'dimension' => $dim,
                            'key'       => $key,
                            'diff'      => round($diff, 4),
                            'from'      => $firstDim[$key],
                            'to'        => $value
                        ];
                        if ($diff > 0) {
                            $trends['increase'][] = $item;
                        } else {
                            $trends['decrease'][] = $item;
                        }
                    }
                }
            }
        }

        return $trends;
    }

    /**
     * [FIX BUG-02] Menghitung skor konsistensi (stability) berdasarkan varians hasil asesmen.
     * Menggunakan semua identitas terhubung (personal + anonymous yang di-link).
     *
     * @param int|null $userId
     * @param int|null $identityId
     * @return array
     */
    public function calculateStability(?int $userId = null, ?int $identityId = null): array
    {
        $identityIds = $this->resolveIdentityIds($userId, $identityId);

        if (empty($identityIds)) {
            return ['score' => 0, 'status' => 'No Data', 'description' => 'Tidak ada data asesmen'];
        }

        $results = AssessmentResult::whereIn('identity_id', $identityIds)
            ->latest('created_at')
            ->take(5)
            ->get();

        if ($results->count() < 2) {
            return [
                'score'       => 1.0,
                'status'      => 'Baseline',
                'description' => 'Asesmen pertama Anda selesai!'
            ];
        }

        $scoresPerKey = [];

        foreach ($results as $result) {
            $data = array_merge($result->input_trait ?? [], $result->input_riasec ?? []);
            foreach ($data as $key => $val) {
                $scoresPerKey[$key][] = $val;
            }
        }

        $variances = [];
        foreach ($scoresPerKey as $key => $values) {
            if (count($values) < 2) {
                continue;
            }
            $variances[] = $this->calculateVariance($values);
        }

        $avgVariance = count($variances) > 0 ? array_sum($variances) / count($variances) : 0;

        // Transformasi Variance ke Score 0-1
        // Jika rata-rata varians adalah 0.1 (fluktuasi tinggi), skor stabilitas menjadi 0.
        $stabilityScore = max(0, 1 - ($avgVariance * 10));

        $status      = 'Explorer';
        $description = 'Masih eksplorasi (Jawaban berubah-ubah)';

        if ($stabilityScore >= 0.8) {
            $status      = 'Stable';
            $description = 'Sangat stabil (Pola karakter sangat konsisten)';
        } elseif ($stabilityScore >= 0.5) {
            $status      = 'Emerging';
            $description = 'Cukup stabil (Ada sedikit pergeseran minat)';
        }

        return [
            'score'        => round($stabilityScore, 2),
            'status'       => $status,
            'description'  => $description,
            'avg_variance' => round($avgVariance, 4)
        ];
    }

    /**
     * Menambahkan nilai atribut dari sebuah array dimensi ke array akumulator.
     */
    private function sumDimension(array &$aggregated, array &$counts, ?array $input): void
    {
        if (empty($input)) {
            return;
        }

        foreach ($input as $key => $value) {
            if (!isset($aggregated[$key])) {
                $aggregated[$key] = 0;
                $counts[$key]     = 0;
            }
            $aggregated[$key] += $value;
            $counts[$key]++;
        }
    }

    /**
     * Menghitung rata-rata dari atribut dimensi yang terakumulasi.
     */
    private function calculateAverage(array $aggregated, array $counts): array
    {
        $result = [];
        foreach ($aggregated as $key => $sum) {
            $result[$key] = $counts[$key] > 0 ? $sum / $counts[$key] : 0;
        }
        return $result;
    }

    /**
     * Menghitung varians populasi dari sekumpulan nilai.
     */
    private function calculateVariance(array $values): float
    {
        $n = count($values);
        if ($n === 0) {
            return 0;
        }
        $mean  = array_sum($values) / $n;
        $sumSq = 0;
        foreach ($values as $v) {
            $sumSq += pow($v - $mean, 2);
        }
        return $sumSq / $n;
    }
}
