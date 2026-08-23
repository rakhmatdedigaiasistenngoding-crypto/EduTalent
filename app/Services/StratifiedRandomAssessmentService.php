<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * ===================================================================
 * FILE 1: StratifiedRandomAssessmentService
 * ===================================================================
 *
 * TUJUAN:
 * Menampilkan 20 soal kepada pengguna (dari total 176) menggunakan
 * metode Acak Terstruktur (Stratified Random Sampling) untuk fase
 * UJI COBA / KALIBRASI.
 *
 * MENGAPA STRATIFIED RANDOM?
 * Pengacakan buta (pure random) berisiko memberikan distribusi
 * yang tidak merata antar modul atau sub-dimensi, sehingga profil
 * psikometri pengguna tidak dapat dipetakan dengan akurat.
 * Stratified random memastikan setiap dimensi terwakili secara proporsional.
 *
 * ATURAN BISNIS YANG DIIMPLEMENTASIKAN:
 * - Total 20 soal dari 176 soal bank.
 * - Karakter (Big Five): 6 soal → ~1-2 per sub-dimensi (5 sub-dim).
 * - Minat (RIASEC):      6 soal → 1 per sub-dimensi (6 sub-dim).
 * - Nilai Kerja:         4 soal → ~1 per sub-dimensi (dipilih 4 dari 6 sub-dim).
 * - Preferensi Lingkungan: 4 soal → ~1 per sub-dimensi (dipilih 4 dari 6 sub-dim).
 * - WAJIB min. 1 item reflektif per sub-dimensi yang ditarik.
 *
 * INTEGRASI KE PROYEK:
 * Gunakan service ini di AssessmentController::form() untuk menggantikan
 * `Question::all()` yang menampilkan semua soal sekaligus.
 *
 * @package App\Services
 */
class StratifiedRandomAssessmentService
{
    /**
     * Konfigurasi jumlah soal yang diambil per modul.
     * Ubah nilai di sini jika proporsi perlu disesuaikan.
     * TOTAL HARUS = 40.
     */
    private const MODULE_QUOTAS = [
        'karakter'                => 6,
        'minat'                   => 6,
        'nilai_kerja'             => 4,
        'preferensi_lingkungan'   => 4,
    ];

    /**
     * Sub-dimensi per modul beserta kuota distribusinya.
     * Kunci = nama sub_dimension di database.
     * Nilai = jumlah soal yang diambil dari sub-dimensi tersebut.
     *
     * Untuk modul Karakter: total 13 dibagi ke 5 sub-dim → 3,3,3,2,2
     * Untuk modul Minat (RIASEC): total 12 dibagi ke 6 sub-dim → 2,2,2,2,2,2
     * Untuk Nilai Kerja: total 8 dibagi ke 6 sub-dim → 2,2,1,1,1,1
     * Untuk Preferensi: total 7 dibagi ke 6 sub-dim → 2,1,1,1,1,1
     */
    private const SUB_DIMENSION_QUOTAS = [
        'karakter' => [
            'openness'             => 2,
            'conscientiousness'    => 1,
            'extraversion'         => 1,
            'agreeableness'        => 1,
            'emotional_stability'  => 1,
        ],
        'minat' => [
            'realistic'            => 1,
            'investigative'        => 1,
            'artistic'             => 1,
            'social'               => 1,
            'enterprising'         => 1,
            'conventional'         => 1,
        ],
        'nilai_kerja' => [
            'stabilitas_keamanan'       => 1,
            'prestasi_pengakuan'        => 1,
            'pelayanan_sosial'          => 1,
            'uang/gaji'                 => 1,
            'kemandirian_fleksibilitas' => 0,
            'kreativitas_inovasi'       => 0,
        ],
        'preferensi_lingkungan' => [
            'struktur_fleksibilitas'   => 1,
            'individu_kolaboratif'     => 1,
            'stabil_dinamis'           => 1,
            'tekanan_rendah_tinggi'    => 1,
            'formal_santai'            => 0,
            'lapangan_ruang_tertutup'  => 0,
        ],
    ];

    /**
     * Ambil 40 soal terstruktur dari bank soal.
     *
     * Fungsi utama yang dipanggil oleh Controller.
     * Mengembalikan Collection berisi objek Question yang sudah diacak
     * secara terstruktur, siap dirender ke view.
     *
     * @return Collection<Question>  Koleksi 40 soal yang dipilih.
     */
    public function draw(): Collection
    {
        $selectedIds = [];

        // Iterasi setiap modul dan ambil soal sesuai kuota
        foreach (self::SUB_DIMENSION_QUOTAS as $module => $subDimQuotas) {
            $moduleItems = $this->drawFromModule($module, $subDimQuotas);
            $selectedIds = array_merge($selectedIds, $moduleItems);
        }

        // Validasi total soal yang berhasil diambil
        $total = count($selectedIds);
        if ($total !== array_sum(self::MODULE_QUOTAS)) {
            Log::warning('[StratifiedRandom] Jumlah soal terpilih tidak sesuai target.', [
                'expected' => array_sum(self::MODULE_QUOTAS),
                'actual'   => $total,
            ]);
        }

        // Ambil soal dari database berdasarkan ID yang terpilih
        $questions = Question::whereIn('id', $selectedIds)
            ->orderBy('module')
            ->orderBy('sub_dimension')
            ->orderBy('display_order')
            ->get();

        // Acak urutan tampil akhir agar tidak monoton per modul
        return $questions->shuffle();
    }

    /**
     * Ambil soal dari satu modul secara terstruktur per sub-dimensi.
     *
     * Untuk modul 'karakter', aturan tambahan diterapkan:
     * WAJIB minimal 1 item reflektif per sub-dimensi.
     *
     * @param string $module         Nama modul (misal 'karakter').
     * @param array  $subDimQuotas   Array [sub_dim => jumlah_soal].
     * @return array                 Array ID soal yang terpilih.
     */
    private function drawFromModule(string $module, array $subDimQuotas): array
    {
        $selectedIds = [];
        // Sekarang seluruh modul sudah memiliki item reflektif
        $requiresReflective = true;

        foreach ($subDimQuotas as $subDimension => $quota) {
            if ($quota <= 0) continue;

            $subDimIds = $this->drawFromSubDimension(
                module: $module,
                subDimension: $subDimension,
                quota: $quota,
                mustIncludeReflective: $requiresReflective
            );
            $selectedIds = array_merge($selectedIds, $subDimIds);
        }

        return $selectedIds;
    }

    /**
     * Ambil soal dari satu sub-dimensi dengan logika reflektif.
     *
     * Algoritma:
     * 1. Jika wajib reflektif: PERTAMA ambil 1 soal reflektif secara acak.
     *    Sisa kuota (quota - 1) diisi dari soal non-reflektif.
     * 2. Jika tidak wajib reflektif: acak dari semua soal sub-dimensi.
     * 3. Jika bank soal kurang dari kuota, log warning dan ambil semua.
     *
     * @param string $module                Nama modul.
     * @param string $subDimension          Nama sub-dimensi.
     * @param int    $quota                 Jumlah soal yang harus diambil.
     * @param bool   $mustIncludeReflective Apakah wajib ada 1 reflektif.
     * @return array                        Array ID soal yang terpilih.
     */
    private function drawFromSubDimension(
        string $module,
        string $subDimension,
        int $quota,
        bool $mustIncludeReflective
    ): array {
        $selected = [];

        // ---- LANGKAH 1: Ambil 1 item reflektif (jika wajib) ----
        if ($mustIncludeReflective) {
            $reflectiveItem = Question::where('module', $module)
                ->where('sub_dimension', $subDimension)
                ->where('is_reflective', true)
                ->inRandomOrder()
                ->first();

            if ($reflectiveItem) {
                $selected[] = $reflectiveItem->id;
                $quota--; // Kurangi sisa kuota
            } else {
                // Jika tidak ada soal reflektif di sub-dimensi ini, log warning
                Log::warning('[StratifiedRandom] Tidak ada soal reflektif.', [
                    'module'        => $module,
                    'sub_dimension' => $subDimension,
                ]);
            }
        }

        // ---- LANGKAH 2: Isi sisa kuota dari soal non-reflektif ----
        if ($quota > 0) {
            // Exclude ID yang sudah terpilih (soal reflektif di atas)
            $nonReflectiveItems = Question::where('module', $module)
                ->where('sub_dimension', $subDimension)
                ->where('is_reflective', false)
                ->whereNotIn('id', $selected)
                ->inRandomOrder()
                ->take($quota)
                ->pluck('id')
                ->toArray();

            $selected = array_merge($selected, $nonReflectiveItems);

            // ---- LANGKAH 3: Fallback jika soal non-reflektif tidak cukup ----
            // Ambil soal reflektif tambahan jika stok non-reflektif kurang
            $remainingNeeded = $quota - count($nonReflectiveItems);
            if ($remainingNeeded > 0) {
                $fallbackItems = Question::where('module', $module)
                    ->where('sub_dimension', $subDimension)
                    ->whereNotIn('id', $selected)
                    ->inRandomOrder()
                    ->take($remainingNeeded)
                    ->pluck('id')
                    ->toArray();

                $selected = array_merge($selected, $fallbackItems);

                if ($remainingNeeded > count($fallbackItems)) {
                    Log::warning('[StratifiedRandom] Bank soal tidak mencukupi kuota.', [
                        'module'         => $module,
                        'sub_dimension'  => $subDimension,
                        'needed'         => $remainingNeeded,
                        'available'      => count($fallbackItems),
                    ]);
                }
            }
        }

        return $selected;
    }

    /**
     * Ambil hanya ID soal tanpa memuat objek Question (lebih ringan).
     *
     * Gunakan ini jika frontend hanya butuh ID untuk lazy-loading soal.
     *
     * @return array Array berisi ID soal yang terpilih (40 item).
     */
    public function drawIds(): array
    {
        return $this->draw()->pluck('id')->toArray();
    }

    /**
     * Ringkasan distribusi soal yang terpilih (untuk debugging/audit).
     *
     * @return array Distribusi per modul dan sub-dimensi.
     */
    public function getDistributionSummary(): array
    {
        $questions = $this->draw();
        $summary = [];

        foreach ($questions->groupBy('module') as $module => $items) {
            $summary[$module] = [
                'total' => $items->count(),
                'sub_dimensions' => $items->groupBy('sub_dimension')
                    ->map(fn($subItems) => [
                        'total'      => $subItems->count(),
                        'reflective' => $subItems->where('is_reflective', true)->count(),
                    ])
                    ->toArray(),
            ];
        }

        return $summary;
    }
}
