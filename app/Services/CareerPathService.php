<?php

namespace App\Services;

class CareerPathService
{
    /**
     * Generate simulasi jalur karir berdasarkan profesi yang direkomendasikan.
     */
    public function generatePath($profession)
    {
        if (empty($profession) || !isset($profession['name'])) {
            return [];
        }

        $name = $profession['name'];
        $domain = $profession['domain'] ?? '';

        // Detailing progression based on domain
        $progression = [
            'start' => "Entry Level / Junior {$name}",
            'mid'   => "Senior / Lead {$name}",
            'end'   => "Expert / Principal / Managerial di bidang {$name}"
        ];

        if (stripos($domain, 'Tech') !== false) {
            $progression = [
                'start' => "Junior Developer / QA / Support ({$name})",
                'mid'   => "Senior Engineer / Systems Architect",
                'end'   => "CTO / IT Director / Distinguished Engineer"
            ];
        } elseif (stripos($domain, 'Creative') !== false) {
            $progression = [
                'start' => "Junior Designer / Artist / Content Creator",
                'mid'   => "Art Director / Senior Creative Specialist",
                'end'   => "Creative Director / Chief Design Officer"
            ];
        } elseif (stripos($domain, 'Health') !== false || stripos($domain, 'Science') !== false) {
            $progression = [
                'start' => "Asisten / Junior Researcher / Practitioner",
                'mid'   => "Senior Specialist / Senior Researcher",
                'end'   => "Head of Research / Lead Consultant / Expert"
            ];
        }

        return $progression;
    }

    /**
     * Identifikasi skill detail dan metode mendapatkannya.
     */
    public function skillGap($result, $profession)
    {
        if (empty($profession)) {
            return [];
        }

        $domain = $profession['domain'] ?? '';
        
        $detailedSkills = [
            ['skill' => "Technical Mastery (Tool & Software)", 'method' => "Self-learning / Online Course"],
            ['skill' => "Professional Communication", 'method' => "Organisasi / Public Speaking Class"],
            ['skill' => "Problem Solving & Analytical Thinking", 'method' => "Studi Kasus / Magang"],
        ];

        if (stripos($domain, 'Tech') !== false) {
            $detailedSkills = [
                ['skill' => "Algoritma & Struktur Data Spesifik", 'method' => "Bootcamp / Coding Challenge (LeetCode)"],
                ['skill' => "Cloud Infrastructure & DevOps Basics", 'method' => "Sertifikasi (AWS/Google Cloud)"],
                ['skill' => "Collaboration Tools (Git/Jira)", 'method' => "Project Magang / Open Source"],
            ];
        } elseif (stripos($domain, 'Business') !== false) {
            $detailedSkills = [
                ['skill' => "Data Analysis & Business Intelligence", 'method' => "Kursus Excel Advanced / SQL"],
                ['skill' => "Strategic Negotiation", 'method' => "Roleplay / Pengalaman Sales & Marketing"],
                ['skill' => "Project Management Methodologies", 'method' => "Sertifikasi CAPM / PMP"],
            ];
        } elseif (stripos($domain, 'Social') !== false || stripos($domain, 'Service') !== false) {
            $detailedSkills = [
                ['skill' => "Psikologi & Perilaku Manusia", 'method' => "Workshop / Seminar / Sertifikasi Profesi"],
                ['skill' => "Crisis Management & Empathy", 'method' => "Volunteering / Community Service"],
                ['skill' => "Advanced Public Speaking", 'method' => "Toastmasters / Praktik Profesional"],
            ];
        }

        return $detailedSkills;
    }

    /**
     * Jalur pendidikan mendetail (SMK, S1, Kursus).
     */
    public function educationPath($profession)
    {
        if (empty($profession)) {
            return [];
        }

        $domain = $profession['domain'] ?? $profession['metadata']['domain'] ?? '';
        $name = $profession['name'] ?? 'profesi ini';

        if (stripos($domain, 'Tech') !== false || stripos($domain, 'Informatika') !== false || stripos($domain, 'Teknologi') !== false) {
            return [
                ['level' => 'SMK', 'majors' => ['RPL', 'TKJ', 'Multimedia'], 'reason' => "Fondasi teknis yang kuat untuk jalur karir di bidang {$name}."],
                ['level' => 'D3 / S1', 'majors' => ['Informatika', 'Sistem Informasi', 'Teknik Komputer'], 'reason' => "Gelar akademik yang paling relevan dan diakui industri untuk profesi {$name}."],
                ['level' => 'Non-Formal', 'majors' => ['Bootcamp Fullstack', 'Mobile Dev', 'Cloud Computing'], 'reason' => "Akselerasi karir dengan sertifikasi praktis yang diakui industri."],
                ['level' => 'Magang', 'majors' => ['Software House', 'Tech Startup', 'BUMN Teknologi'], 'reason' => "Pengalaman kerja nyata untuk memperkuat portofolio Anda."],
            ];
        } elseif (stripos($domain, 'Creative') !== false || stripos($domain, 'Desain') !== false || stripos($domain, 'Seni') !== false) {
            return [
                ['level' => 'SMK', 'majors' => ['Multimedia', 'DKV', 'Animasi'], 'reason' => "Fondasi kreatif yang solid untuk berkembang di bidang {$name}."],
                ['level' => 'D3 / S1', 'majors' => ['DKV', 'Desain Produk', 'Seni Rupa'], 'reason' => "Gelar akademik yang memperdalam kemampuan kreatif dan konseptual."],
                ['level' => 'Non-Formal', 'majors' => ['UI/UX Design', '3D Modeling', 'Motion Graphics'], 'reason' => "Spesialisasi keahlian yang langsung relevan dengan kebutuhan industri kreatif."],
                ['level' => 'Magang', 'majors' => ['Creative Agency', 'Production House', 'Game Studio'], 'reason' => "Membangun portofolio nyata di lingkungan profesional."],
            ];
        } elseif (stripos($domain, 'Business') !== false || stripos($domain, 'Finance') !== false || stripos($domain, 'Bisnis') !== false) {
            return [
                ['level' => 'SMK', 'majors' => ['Akuntansi', 'Pemasaran', 'Administrasi'], 'reason' => "Pemahaman dasar bisnis dan keuangan untuk karir di bidang {$name}."],
                ['level' => 'D3 / S1', 'majors' => ['Manajemen', 'Akuntansi', 'Ekonomi Bisnis'], 'reason' => "Gelar yang membuka akses ke posisi manajerial dan profesional."],
                ['level' => 'Non-Formal', 'majors' => ['Digital Marketing', 'Financial Analyst', 'Brevet Pajak'], 'reason' => "Sertifikasi yang meningkatkan daya saing di pasar kerja."],
                ['level' => 'Magang', 'majors' => ['Perbankan', 'Korporasi (Finance)', 'Startup Bisnis'], 'reason' => "Pengalaman praktis dalam lingkungan bisnis yang sesungguhnya."],
            ];
        } elseif (stripos($domain, 'Health') !== false || stripos($domain, 'Science') !== false || stripos($domain, 'Kesehatan') !== false) {
            return [
                ['level' => 'SMK', 'majors' => ['Keperawatan', 'Farmasi', 'Kimia Industri'], 'reason' => "Dasar-dasar ilmu kesehatan dan sains untuk karir di bidang {$name}."],
                ['level' => 'D3 / S1', 'majors' => ['Kedokteran', 'Farmasi', 'Biologi', 'Teknik Kimia'], 'reason' => "Gelar akademik wajib untuk praktisi di bidang kesehatan dan sains."],
                ['level' => 'Non-Formal', 'majors' => ['Sertifikasi Lab', 'Workshop Klinis', 'CPD Kesehatan'], 'reason' => "Peningkatan kompetensi berkelanjutan yang disyaratkan profesi."],
                ['level' => 'Magang', 'majors' => ['Rumah Sakit', 'Lab Riset', 'Industri Farmasi'], 'reason' => "Pengalaman klinis nyata yang krusial dalam pengembangan karir."],
            ];
        } elseif (stripos($domain, 'Social') !== false || stripos($domain, 'Service') !== false || stripos($domain, 'Sosial') !== false) {
            return [
                ['level' => 'SMK', 'majors' => ['Pariwisata', 'Pekerjaan Sosial', 'Tata Boga'], 'reason' => "Keterampilan dasar layanan dan interaksi sosial untuk profesi {$name}."],
                ['level' => 'D3 / S1', 'majors' => ['Psikologi', 'Komunikasi', 'Sosiologi', 'Hub. Internasional'], 'reason' => "Gelar yang memperdalam pemahaman perilaku manusia dan dinamika sosial."],
                ['level' => 'Non-Formal', 'majors' => ['Public Relations', 'Konseling Dasar', 'Community Management'], 'reason' => "Keahlian praktis yang langsung bisa diterapkan di lapangan."],
                ['level' => 'Magang', 'majors' => ['NGO', 'Institusi Pendidikan', 'Perhotelan'], 'reason' => "Pengalaman langsung dalam melayani dan berinteraksi dengan masyarakat."],
            ];
        }

        // Default (domain umum)
        return [
            ['level' => 'SMK', 'majors' => ['Semua Jurusan Relevan'], 'reason' => "Fondasi akademik untuk memulai perjalanan karir di bidang {$name}."],
            ['level' => 'D3 / S1', 'majors' => ['Pilih bidang yang mendukung ' . $name], 'reason' => "Gelar akademik yang memperluas peluang dan jenjang karir Anda."],
            ['level' => 'Non-Formal', 'majors' => ['Kursus', 'Sertifikasi Profesional'], 'reason' => "Investasi terbaik untuk meningkatkan daya saing di pasar kerja."],
            ['level' => 'Magang', 'majors' => ['Industri terkait ' . $name], 'reason' => "Pengalaman praktis yang menjadi pembeda di mata rekruter."],
        ];
    }


    /**
     * Simulasi "Jika Anda Mengembangkan X" berdasarkan trait terendah.
     */
    public function simulateGrowth($result, $profession)
    {
        if (empty($result->input_trait) || empty($profession)) {
            return [];
        }

        $traits = $result->input_trait;
        $name = $profession['name'];
        
        // Cari trait terendah
        asort($traits);
        $lowestTraitKey = key($traits);
        $lowestScore = current($traits);

        $traitLabels = [
            'O' => 'Openness (Keterbukaan)',
            'C' => 'Conscientiousness (Kehati-hatian)',
            'E' => 'Extraversion (Ekstraversi)',
            'A' => 'Agreeableness (Keramahan)',
            'N' => 'Neuroticism (Stabilitas Emosi)',
        ];

        $traitName = $traitLabels[$lowestTraitKey] ?? $lowestTraitKey;

        // Narasi dinamis berdasarkan trait yang perlu ditingkatkan
        $narration = [];
        
        if ($lowestTraitKey == 'O') {
            $narration[] = "Jika Anda mengasah aspek **{$traitName}**, Anda akan lebih cepat beradaptasi dengan teknologi atau tren baru di bidang {$name}.";
            $narration[] = "Kreativitas yang meningkat akan membuat solusi yang Anda tawarkan lebih inovatif dibanding rekan sejawat.";
        } elseif ($lowestTraitKey == 'C') {
            $narration[] = "Dengan meningkatkan **{$traitName}**, tingkat ketelitian Anda dalam menangani proyek {$name} akan meminimalisir risiko kesalahan.";
            $narration[] = "Anda akan dikenal sebagai profesional yang sangat reliabel dan terorganisir di mata atasan/klien.";
        } elseif ($lowestTraitKey == 'E') {
            $narration[] = "Pengembangan aspek **{$traitName}** akan memperluas jaringan (networking) Anda, yang sangat krusial untuk akselerasi karir di bidang {$name}.";
            $narration[] = "Anda akan lebih percaya diri saat harus mempresentasikan ide atau memimpin tim kecil.";
        } elseif ($lowestTraitKey == 'A') {
            $narration[] = "Meningkatkan **{$traitName}** akan memperkuat kemampuan kolaborasi tim Anda, membuat lingkungan kerja di sekitar {$name} lebih harmonis.";
            $narration[] = "Kemampuan negosiasi dan win-win solution Anda akan menjadi aset berharga dalam jangka panjang.";
        } elseif ($lowestTraitKey == 'N') {
            $narration[] = "Dengan memperkuat **Stabilitas Emosi**, Anda akan tetap tenang dan produktif saat menghadapi tekanan tinggi (deadline/krisis) di bidang {$name}.";
            $narration[] = "Ketahanan mental ini adalah kunci untuk mencapai level pimpinan (Expert/Lead) lebih cepat.";
        }

        // [TEMUAN-3 FIX] Fallback jika trait key tidak dikenali (misal: key numerik atau custom)
        if (empty($narration)) {
            $narration[] = "Dengan terus mengembangkan diri secara konsisten, peluang dan daya saing Anda di bidang {$name} akan semakin meningkat secara signifikan.";
            $narration[] = "Setiap langkah kecil dalam pengembangan diri akan memberikan dampak nyata pada perjalanan karir Anda ke depannya.";
        }

        return [
            'trait' => $traitName,
            'narration' => $narration
        ];
    }

    /**
     * Berikan rencana aksi konkret (Checklist) bagi user.
     */
    public function actionPlan($profession)
    {
        if (empty($profession)) {
            return [];
        }

        $name = $profession['name'];

        return [
            "Identifikasi & pelajari 3 skill teknis utama di bidang {$name} (Target: 3 bulan)",
            "Cari dan ikuti setidaknya 1 pelatihan atau kursus bersertifikat yang relevan",
            "Mulai bangun portofolio proyek sederhana atau dokumentasi karya terkait {$name}",
            "Cari mentor atau bergabung dengan komunitas profesional di bidang {$name}",
            "Persiapkan pengalaman praktis melalui magang atau proyek sukarela"
        ];
    }
}
