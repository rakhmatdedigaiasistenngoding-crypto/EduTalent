<?php

namespace App\Services;

use App\Models\AssessmentResult;

class InsightService
{
    /**
     * Label untuk Trait (Big Five simplified).
     */
    protected array $traitLabels = [
        0 => 'berinisiatif tinggi',           // Openness
        1 => 'teliti dan detail',              // Conscientiousness
        2 => 'adaptif terhadap perubahan',     // Extraversion
        3 => 'empatik dan kolaboratif',        // Agreeableness
        4 => 'stabil secara emosional',        // Emotional Stability
    ];

    /**
     * Label untuk RIASEC.
     */
    protected array $riasecLabels = [
        0 => ['code' => 'R', 'name' => 'Realistic', 'desc' => 'menyukai pekerjaan praktis dan hands-on'],
        1 => ['code' => 'I', 'name' => 'Investigative', 'desc' => 'senang menganalisis dan memecahkan masalah'],
        2 => ['code' => 'A', 'name' => 'Artistic', 'desc' => 'kreatif dan menyukai ekspresi diri'],
        3 => ['code' => 'S', 'name' => 'Social', 'desc' => 'senang membantu dan berinteraksi dengan orang lain'],
        4 => ['code' => 'E', 'name' => 'Enterprising', 'desc' => 'berjiwa kepemimpinan dan persuasif'],
        5 => ['code' => 'C', 'name' => 'Conventional', 'desc' => 'terorganisir dan menyukai keteraturan'],
    ];

    /**
     * Label untuk Environment.
     */
    /**
     * Label untuk 6 dimensi Environment (bipolar, skala 0.0-1.0).
     * Sesuai dengan data PROFESSIONS di mini dan ScoringService (6 sub-dimensi).
     */
    protected array $envLabels = [
        0 => ['low' => 'teknis/analitis',           'high' => 'komunikatif/interpersonal'],
        1 => ['low' => 'mandiri/independen',         'high' => 'kolaboratif/tim'],
        2 => ['low' => 'stabil dan rutin',           'high' => 'dinamis dan cepat berubah'],
        3 => ['low' => 'bertekanan rendah/santai',   'high' => 'bertekanan tinggi/kompetitif'],
        4 => ['low' => 'formal dan terstruktur',     'high' => 'santai dan fleksibel'],
        5 => ['low' => 'indoor/kantor',              'high' => 'outdoor/lapangan'],
    ];

    /**
     * Generate ringkasan insight dari hasil asesmen.
     */
    public function generateSummary(AssessmentResult $result): string
    {
        $sentences = [];

        // 1. Analisis Trait — karakter dominan
        $traitSentence = $this->analyzeTraits($result->input_trait ?? []);
        if ($traitSentence) {
            $sentences[] = $traitSentence;
        }

        // 2. Analisis RIASEC — minat dominan
        $riasecSentence = $this->analyzeRiasec($result->input_riasec ?? []);
        if ($riasecSentence) {
            $sentences[] = $riasecSentence;
        }

        // 3. Analisis Environment — preferensi lingkungan
        $envSentence = $this->analyzeEnvironment($result->input_environment ?? []);
        if ($envSentence) {
            $sentences[] = $envSentence;
        }

        // 4. Rekomendasi profesi teratas
        $profSentence = $this->analyzeTopProfession($result->result_top_n ?? []);
        if ($profSentence) {
            $sentences[] = $profSentence;
        }

        return implode(' ', $sentences) ?: 'Data belum cukup untuk menghasilkan ringkasan.';
    }

    /**
     * Analisis trait dan hasilkan kalimat deskriptif.
     */
    protected function analyzeTraits(array $traits): ?string
    {
        if (empty($traits)) return null;

        // [FIX BUG-C] Gunakan posisi numerik (re-index via array_values) bukan key asli array
        // Hal ini memastikan lookup ke $traitLabels[0,1,2] selalu benar,
        // baik input menggunakan numeric key (0,1,2) maupun string key ('openness','conscientiousness',...)
        $values = array_values($traits);
        $maxVal = max($values);
        $maxIndex = array_search($maxVal, $values); // Posisi 0,1,2 sesuai urutan $traitLabels

        $label = $this->traitLabels[$maxIndex] ?? null;

        if (!$label) return null;

        // Ambil nilai asli (dari keys asli) untuk menentukan intensitas
        $originalKeys = array_keys($traits);
        $originalKey = $originalKeys[$maxIndex] ?? $maxIndex;
        $value = $traits[$originalKey] ?? $maxVal;

        $intensity = $value >= 7 ? 'sangat' : ($value >= 4 ? 'cukup' : 'sedikit');

        return "Anda {$intensity} {$label}, menunjukkan karakter yang menonjol dalam aspek tersebut.";
    }

    /**
     * Analisis RIASEC dan hasilkan kalimat deskriptif.
     */
    protected function analyzeRiasec(array $riasec): ?string
    {
        if (empty($riasec)) return null;

        // Temukan 2 RIASEC tertinggi
        $indexed = [];
        foreach ($riasec as $i => $val) {
            $indexed[$i] = $val;
        }
        arsort($indexed);
        $topTwo = array_slice($indexed, 0, 2, true);

        $descriptions = [];
        foreach ($topTwo as $i => $val) {
            if (isset($this->riasecLabels[$i])) {
                $descriptions[] = $this->riasecLabels[$i]['desc'];
            }
        }

        if (empty($descriptions)) return null;

        return 'Minat Anda menunjukkan bahwa Anda ' . implode(' serta ', $descriptions) . '.';
    }

    /**
     * Analisis preferensi lingkungan kerja.
     */
    protected function analyzeEnvironment(array $env): ?string
    {
        if (empty($env)) return null;

        $prefs = [];
        foreach ($env as $i => $val) {
            if (!isset($this->envLabels[$i])) continue;
            // Threshold: > 0.5 = high preference (skala 0.0-1.0)
            // Hanya tampilkan jika nilai cukup jauh dari tengah (> 0.6 atau < 0.4)
            if ($val > 0.6) {
                $prefs[] = $this->envLabels[$i]['high'];
            } elseif ($val < 0.4) {
                $prefs[] = $this->envLabels[$i]['low'];
            }
            // Nilai tengah (0.4-0.6) diabaikan karena tidak cukup distinktif
        }

        if (empty($prefs)) return null;

        return 'Anda cocok di lingkungan kerja yang ' . implode(', ', $prefs) . '.';
    }

    /**
     * Ringkasan profesi teratas.
     */
    protected function analyzeTopProfession(array $topN): ?string
    {
        if (empty($topN)) return null;

        $top = $topN[0] ?? null;
        if (!$top || !isset($top['name'])) return null;

        $score = isset($top['score']) ? round($top['score'] * 100, 1) : 0;

        return "Profesi yang paling cocok untuk Anda adalah **{$top['name']}** dengan tingkat kecocokan {$score}%.";
    }

    /**
     * Generate alasan mengapa profesi teratas cocok dengan user.
     * Mengembalikan array berisi maksimal 3 bullet point.
     */
    public function generateReason(AssessmentResult $result): array
    {
        $reasons = [];
        $topN = $result->result_top_n ?? [];
        $traits = $result->input_trait ?? [];
        $riasec = $result->input_riasec ?? [];
        $env = $result->input_environment ?? [];

        if (empty($topN)) return [];

        $top = $topN[0];
        $details = $top['details'] ?? [];

        // 1. Alasan berdasarkan Trait — cari trait tertinggi user
        if (!empty($traits)) {
            $maxTraitIndex = array_keys($traits, max($traits))[0];
            $traitLabel = $this->traitLabels[$maxTraitIndex] ?? null;
            $traitScore = isset($details['trait']) ? round($details['trait'] * 100, 0) : null;

            if ($traitLabel && $traitScore) {
                $reasons[] = "Karakter Anda yang {$traitLabel} memiliki kecocokan {$traitScore}% dengan profesi ini.";
            }
        }

        // 2. Alasan berdasarkan RIASEC — cari minat dominan
        if (!empty($riasec)) {
            $indexed = $riasec;
            arsort($indexed);
            $topRiasecIndex = array_key_first($indexed);
            $riasecLabel = $this->riasecLabels[$topRiasecIndex] ?? null;
            $riasecScore = isset($details['riasec']) ? round($details['riasec'] * 100, 0) : null;

            if ($riasecLabel && $riasecScore) {
                $reasons[] = "Minat {$riasecLabel['name']} Anda ({$riasecLabel['desc']}) sesuai dengan kebutuhan profesi ini ({$riasecScore}%).";
            }
        }

        // 3. Alasan berdasarkan Environment
        if (!empty($env)) {
            $envScore = isset($details['environment']) ? round($details['environment'] * 100, 0) : null;
            $envPrefs = [];
            foreach ($env as $i => $val) {
                if (!isset($this->envLabels[$i])) continue;
                // Fix: gunakan threshold 0.5 (skala 0.0-1.0)
                if ($val > 0.6) {
                    $envPrefs[] = $this->envLabels[$i]['high'];
                } elseif ($val < 0.4) {
                    $envPrefs[] = $this->envLabels[$i]['low'];
                }
            }

            if ($envScore && !empty($envPrefs)) {
                $reasons[] = "Preferensi lingkungan kerja Anda (" . implode(', ', $envPrefs) . ") cocok {$envScore}% dengan profesi ini.";
            }
        }

        return array_slice($reasons, 0, 3);
    }

    /**
     * Membandingkan hasil saat ini dengan hasil sebelumnya.
     */
    public function generateComparison(AssessmentResult $current, ?AssessmentResult $previous): array
    {
        if (!$previous) {
            return [
                'status' => 'new',
                'message' => 'Ini adalah asesmen pertama Anda. Lakukan asesmen lagi di masa depan untuk melihat perkembangan karakter dan minat Anda.'
            ];
        }

        $insights = [];
        $currTraits = $current->input_trait ?? [];
        $prevTraits = $previous->input_trait ?? [];
        $currRiasec = $current->input_riasec ?? [];
        $prevRiasec = $previous->input_riasec ?? [];

        // 1. Bandingkan Trait
        if (!empty($currTraits) && !empty($prevTraits)) {
            $traitChanges = [];
            foreach ($currTraits as $i => $val) {
                if (!isset($prevTraits[$i])) continue;
                $diff = $val - $prevTraits[$i];
                if (abs($diff) >= 2) { // Signifikan jika berubah >= 2 poin
                    $traitChanges[$i] = $diff;
                }
            }

            if (!empty($traitChanges)) {
                // Ambil perubahan terbesar
                arsort($traitChanges);
                $maxIncreaseIndex = array_key_first($traitChanges);
                $maxIncreaseValue = $traitChanges[$maxIncreaseIndex];

                if ($maxIncreaseValue > 0 && isset($this->traitLabels[$maxIncreaseIndex])) {
                    $label = str_replace('berinisiatif tinggi', 'inisiatif', $this->traitLabels[$maxIncreaseIndex]);
                    $label = str_replace('teliti dan detail', 'ketelitian', $label);
                    $label = str_replace('adaptif terhadap perubahan', 'adaptabilitas', $label);
                    
                    $insights[] = "Anda menunjukkan peningkatan signifikan pada **{$label}** dibandingkan asesmen sebelumnya.";
                }
            }
        }

        // 2. Bandingkan RIASEC
        if (!empty($currRiasec) && !empty($prevRiasec)) {
            // Cari top RIASEC saat ini
            $currTop = $currRiasec;
            arsort($currTop);
            $currTopIndex = array_key_first($currTop);

            // Cari top RIASEC sebelumnya
            $prevTop = $prevRiasec;
            arsort($prevTop);
            $prevTopIndex = array_key_first($prevTop);

            if ($currTopIndex !== $prevTopIndex) {
                $currLabel = $this->riasecLabels[$currTopIndex]['name'] ?? '';
                $prevLabel = $this->riasecLabels[$prevTopIndex]['name'] ?? '';
                if ($currLabel && $prevLabel) {
                    $insights[] = "Fokus minat utama Anda bergeser dari **{$prevLabel}** menjadi **{$currLabel}**.";
                }
            } else {
                $currLabel = $this->riasecLabels[$currTopIndex]['name'] ?? '';
                if ($currLabel) {
                    $insights[] = "Minat utama Anda tetap konsisten di bidang **{$currLabel}**.";
                }
            }
        }

        if (empty($insights)) {
            $insights[] = "Karakter dan minat Anda relatif stabil sejak asesmen terakhir.";
        }

        return [
            'status' => 'compared',
            'date' => $previous->created_at ? $previous->created_at->diffForHumans() : 'sebelumnya',
            'insights' => $insights
        ];
    }

    /**
     * [PHASE-3] Analisis "Reality Check": Bandingkan kondisi saat ini user dengan rekomendasi sistem.
     * Menggunakan data profil dari identity metadata atau AssessmentProfile.
     *
     * @param AssessmentResult $result
     * @param array $profileMeta Metadata dari identity (berisi student_info, university_info, employee_info, survey)
     * @return array ['status', 'current_condition', 'recommendation', 'analysis', 'suggestions']
     */
    public function generateRealityCheck(AssessmentResult $result, array $profileMeta = []): array
    {
        $topN    = $result->result_top_n ?? [];
        $topProf = $topN[0] ?? null;

        if (!$topProf) {
            return ['status' => 'no_data', 'analysis' => 'Data rekomendasi belum tersedia.'];
        }

        $topProfName   = $topProf['name'] ?? $topProf['profession'] ?? 'profesi rekomendasi';
        $topDomain     = $topProf['domain'] ?? '-';
        $topScore      = number_format($topProf['score'] ?? 0, 1);

        // Tentukan kondisi saat ini berdasarkan tipe identitas
        $identityType  = null;
        $currentField  = null;
        $currentLabel  = 'Umum / Belum Bekerja';
        $wantsToStudy  = null; // Untuk pelajar SMA/SMK yang punya rencana jurusan

        if (!empty($profileMeta['student_info'])) {
            $info          = $profileMeta['student_info'];
            $identityType  = 'student';
            $level         = $info['school_level'] ?? '';
            $major         = $info['school_major'] ?? null;
            $school        = $info['school_name'] ?? '-';
            $currentField  = $major ?: $level;
            $currentLabel  = $level === 'SMK' && $major
                ? "Siswa SMK jurusan {$major} di {$school}"
                : "Siswa {$level} di {$school}";

            // Rencana kuliah (dari survei major_decided)
            $survey        = $profileMeta['survey'] ?? [];
            if (($survey['major_decided'] ?? '') === 'Sudah') {
                $wantsToStudy = 'sudah memiliki rencana jurusan kuliah';
            } elseif (($survey['major_decided'] ?? '') === 'Ragu-ragu') {
                $wantsToStudy = 'masih ragu memilih jurusan kuliah';
            } else {
                $wantsToStudy = 'belum menentukan jurusan kuliah';
            }

        } elseif (!empty($profileMeta['university_info'])) {
            $info          = $profileMeta['university_info'];
            $identityType  = 'university_student';
            $currentField  = $info['major'] ?? null;
            $campus        = $info['university_name'] ?? '-';
            $currentLabel  = $currentField
                ? "Mahasiswa {$currentField} di {$campus}"
                : "Mahasiswa di {$campus}";

        } elseif (!empty($profileMeta['employee_info'])) {
            $info          = $profileMeta['employee_info'];
            $identityType  = 'employee';
            $currentField  = $info['job_title'] ?? null;
            $company       = $info['company_name'] ?? '-';
            $currentLabel  = $currentField
                ? "Pekerja sebagai {$currentField} di {$company}"
                : "Pekerja di {$company}";
        }

        // ── Tentukan tingkat kesesuaian ──────────────────────────────────
        $isAligned    = false;
        $alignScore   = 0;

        if ($currentField) {
            // Cek kesamaan kata kunci (sederhana tapi efektif)
            $currentWords  = array_map('strtolower', explode(' ', $currentField));
            $profWords     = array_map('strtolower', explode(' ', $topProfName));
            $domainWords   = array_map('strtolower', explode(' ', $topDomain));
            $allRefWords   = array_merge($profWords, $domainWords);

            $matches       = array_intersect($currentWords, $allRefWords);
            $alignScore    = count($matches) / max(count($currentWords), 1);
            $isAligned     = $alignScore > 0.2;
        }

        // ── Bangun narasi AI ─────────────────────────────────────────────
        $analysis    = '';
        $suggestions = [];

        if (!$currentField) {
            // Umum / tidak ada kondisi spesifik
            $analysis = "Berdasarkan hasil asesmen, sistem merekomendasikan Anda untuk meniti karir sebagai **{$topProfName}** (domain: {$topDomain}) dengan tingkat kesesuaian {$topScore}%. Gunakan rekomendasi ini sebagai panduan awal dalam merencanakan perjalanan karir Anda.";
            $suggestions[] = "Pelajari lebih lanjut tentang profesi {$topProfName} melalui berbagai sumber informasi.";
            $suggestions[] = "Pertimbangkan untuk mengikuti kursus atau pelatihan yang relevan dengan domain {$topDomain}.";

        } elseif ($isAligned) {
            // Kondisi saat ini SELARAS dengan rekomendasi
            $analysis = "🎯 **Selaras!** Kondisi Anda saat ini sebagai *{$currentLabel}* memiliki kesinambungan yang baik dengan rekomendasi sistem: **{$topProfName}**. Ini adalah sinyal positif bahwa Anda berada di jalur yang tepat. Pertahankan dan tingkatkan kompetensi Anda di bidang ini.";
            $suggestions[] = "Perkuat keterampilan utama yang dibutuhkan sebagai {$topProfName}.";
            $suggestions[] = "Cari mentor atau komunitas profesional di bidang {$topDomain}.";
            $suggestions[] = "Pertimbangkan sertifikasi atau pendidikan lanjutan yang mendukung karir ini.";

        } else {
            // Kondisi saat ini TIDAK SELARAS
            $analysis = "⚡ **Perlu Dipertimbangkan.** Kondisi Anda saat ini sebagai *{$currentLabel}* berbeda dengan rekomendasi utama sistem: **{$topProfName}** (domain: {$topDomain}, kesesuaian {$topScore}%). Ini bukan berarti pilihan Anda salah — namun sistem mendeteksi potensi kuat Anda di arah lain berdasarkan karakter dan minat yang terukur.";

            if ($identityType === 'student') {
                $suggestions[] = "Jika Anda {$wantsToStudy}, pertimbangkan program studi yang dekat dengan domain {$topDomain}.";
                $suggestions[] = "Ikuti kegiatan ekstrakurikuler atau proyek yang mengasah potensi di bidang {$topProfName}.";
            } elseif ($identityType === 'university_student') {
                $suggestions[] = "Eksplorasi mata kuliah pilihan atau minor yang bersinggungan dengan domain {$topDomain}.";
                $suggestions[] = "Manfaatkan waktu magang untuk mencoba pengalaman di bidang {$topProfName}.";
            } elseif ($identityType === 'employee') {
                $suggestions[] = "Pertimbangkan apakah ada peluang rotasi atau pengembangan karir menuju {$topDomain} di tempat kerja Anda.";
                $suggestions[] = "Mulai bangun portofolio atau keterampilan tambahan di bidang {$topProfName} secara bertahap.";
            }
            $suggestions[] = "Lakukan konsultasi dengan konselor karir untuk mendapat panduan yang lebih personal.";
        }

        return [
            'status'            => $isAligned ? 'aligned' : ($currentField ? 'misaligned' : 'general'),
            'current_condition' => $currentLabel,
            'recommendation'    => $topProfName,
            'domain'            => $topDomain,
            'score'             => $topScore,
            'analysis'          => $analysis,
            'suggestions'       => $suggestions,
            'wants_to_study'    => $wantsToStudy,
        ];
    }

    /**
     * [PHASE-3] Generate insight dari data survei awal user.
     * Menginterpretasikan 3 jawaban survei dan menghubungkannya dengan hasil asesmen.
     *
     * @param array $survey ['self_awareness', 'has_taken_assessment', 'major_decided']
     * @param float $topScore Skor rekomendasi utama (0-100)
     * @return string
     */
    public function getSurveyInsight(array $survey, float $topScore = 0): string
    {
        if (empty($survey)) return '';

        $parts = [];

        // 1. Pengenalan diri
        $awareness = $survey['self_awareness'] ?? '';
        if ($awareness === 'Sangat mengenal') {
            $parts[] = "Anda mengaku sangat mengenal karakter dan minat Anda. Hal ini memperkuat validitas hasil asesmen ini sebagai konfirmasi dari apa yang sudah Anda rasakan.";
        } elseif ($awareness === 'Cukup mengenal') {
            $parts[] = "Anda merasa cukup mengenal diri sendiri. Hasil asesmen ini dapat membantu memperjelas dan memperkuat pemahaman Anda.";
        } else {
            $parts[] = "Anda mengaku belum terlalu mengenal karakter dan minat diri. Gunakan hasil asesmen ini sebagai titik awal eksplorasi yang lebih dalam.";
        }

        // 2. Pengalaman asesmen
        $hasTaken = $survey['has_taken_assessment'] ?? '';
        if ($hasTaken === 'Pernah') {
            $parts[] = "Karena Anda pernah mengikuti asesmen serupa sebelumnya, rekomendasi ini dapat Anda bandingkan dengan hasil yang lalu untuk melihat konsistensi profil Anda.";
        } else {
            $parts[] = "Karena ini kemungkinan pertama kali Anda mengikuti asesmen berbasis psikometrik, hasil ini menjadi baseline awal yang sangat berharga.";
        }

        // 3. Keputusan jurusan vs skor
        $majorDecided = $survey['major_decided'] ?? '';
        if ($majorDecided === 'Sudah' && $topScore >= 70) {
            $parts[] = "Anda sudah memiliki pilihan jurusan, dan hasil asesmen menunjukkan kesesuaian yang baik ({$topScore}%) — sebuah tanda yang positif!";
        } elseif ($majorDecided === 'Sudah' && $topScore < 70) {
            $parts[] = "Anda sudah memiliki pilihan jurusan, namun sistem mendeteksi potensi di arah yang sedikit berbeda (kesesuaian {$topScore}%). Pertimbangkan untuk mendiskusikan ini dengan konselor.";
        } elseif ($majorDecided === 'Ragu-ragu') {
            $parts[] = "Anda masih ragu-ragu dalam memilih jurusan — hasil asesmen ini hadir di saat yang tepat untuk membantu Anda.";
        } else {
            $parts[] = "Anda belum menentukan jurusan — manfaatkan rekomendasi ini sebagai panduan utama perencanaan pendidikan Anda.";
        }

        return implode(' ', $parts);
    }

    /**
     * Generate insight naratif berdasarkan profil agregat, tren, dan stabilitas.
     *
     * @param array $profile Profil agregat (output PersonalProfileService::aggregate)
     * @param array $trend Tren perubahan (output PersonalProfileService::detectTrend)
     * @param array $stability Skor stabilitas (output PersonalProfileService::calculateStability)
     * @return string
     */
    public function generateAdaptiveInsight(array $profile, array $trend, array $stability): string
    {
        $status = $stability['status'] ?? '';
        if (in_array($status, ['Baseline', 'No Data'])) {
            return '';
        }

        $narratives = [];

        // 1. Narasi Stabilitas/Konsistensi
        $narratives[] = $stability['description'] ?? 'Profil Anda sedang dalam tahap pemetaan.';

        // 2. Narasi Tren (Minat yang berkembang)
        if (!empty($trend['increase'])) {
            // Urutkan tren peningkatan berdasarkan besaran perubahan (diff)
            $increases = $trend['increase'];
            usort($increases, fn($a, $b) => $b['diff'] <=> $a['diff']);
            
            $topIncrease = $increases[0]; 
            $dim = $topIncrease['dimension'];
            $key = $topIncrease['key'];
            
            $label = '';
            if ($dim === 'riasec' && isset($this->riasecLabels[$key])) {
                $label = $this->riasecLabels[$key]['name'];
            } elseif ($dim === 'trait' && isset($this->traitLabels[$key])) {
                $label = $this->traitLabels[$key];
            }

            if ($label) {
                $narratives[] = "Terlihat pertumbuhan minat yang semakin kuat pada aspek **{$label}**.";
            }
        }

        // 3. Narasi untuk eksplorasi jika stabilitas rendah
        if (($stability['score'] ?? 1) < 0.5 && empty($trend['increase'])) {
            $narratives[] = "Saat ini Anda sedang aktif mengeksplorasi berbagai potensi diri yang berbeda.";
        }

        return implode(' ', array_slice($narratives, 0, 3));
    }
}

