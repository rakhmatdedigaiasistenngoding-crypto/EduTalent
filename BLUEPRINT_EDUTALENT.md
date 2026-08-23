# 📘 BLUEPRINT ARSITEKTUR — EduTalent SMK Budi Karya Natar
**Versi:** 1.0  
**Tanggal:** 2026-08-23  
**Diadaptasi dari:** ShiroPathEdu / Shiro_Asesmen v1  
**Tujuan:** Sistem Asesmen Mandiri Minat, Bakat & Karakter untuk Siswa SMK

---

## 1. RINGKASAN PROYEK

**EduTalent** adalah aplikasi web berbasis Laravel untuk membantu siswa SMK Budi Karya Natar dalam mengidentifikasi minat, bakat, dan karakter mereka secara mandiri. Sistem menggunakan algoritma SPK Hybrid (Profile Matching + SAW) yang dipadukan dengan AI Generatif (Gemini) untuk menghasilkan rekomendasi profesi dan jalur pendidikan yang personal.

### Tujuan Utama
- Membantu siswa memahami diri sendiri (self-assessment)
- Memberikan rekomendasi karir berbasis data psikometrik
- Menyediakan laporan untuk guru/konselor (Admin/Operator)
- Mengumpulkan data untuk penelitian pendidikan lanjutan

---

## 2. TECH STACK

| Layer | Teknologi | Keterangan |
|---|---|---|
| **Backend** | Laravel 13 (PHP 8.3+) | Framework utama |
| **Frontend** | Blade + Alpine.js | SSR, ringan, no heavy SPA |
| **Database** | SQLite (lokal) / MySQL (produksi) | Migrasi via Eloquent ORM |
| **AI/ML** | Google Gemini 1.5 Flash | Generate narasi asesmen |
| **PDF Export** | barryvdh/laravel-dompdf | Laporan siswa & admin |
| **Storage** | Google Drive (via flysystem) | Backup data opsional |
| **CSS** | Tailwind CSS (CDN) | Di dalam views |
| **Build Tool** | Vite | Untuk asset kompilasi |

---

## 3. STRUKTUR FOLDER PROYEK

```
EduTalent/
├── .agents/                   ← Sistem AI Asisten Koding (BARU)
│   ├── AGENTS.md              ← Aturan utama untuk semua AI
│   ├── rules/
│   │   └── strict_compliance.md
│   └── skills/
│       ├── edutalent-new-feature/
│       ├── edutalent-safe-release/
│       └── edutalent-db-safe/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php         ← Login identitas siswa (session-based)
│   │   ├── AssessmentController.php   ← CONTROLLER UTAMA (502 baris)
│   │   ├── AdminDashboardController.php ← Dashboard admin
│   │   ├── FeedbackController.php     ← Feedback pasca asesmen
│   │   ├── HealthCheckController.php  ← Endpoint monitoring
│   │   └── IdentityController.php     ← Link session ↔ akun
│   ├── Models/
│   │   ├── User.php              ← Admin/Operator (login Laravel auth)
│   │   ├── Identity.php          ← Identitas siswa (session/anonim)
│   │   ├── AssessmentProfile.php ← Profil lengkap siswa
│   │   ├── AssessmentResult.php  ← Hasil asesmen (JSON scores)
│   │   ├── AssessmentFeedback.php← Feedback siswa terhadap hasil
│   │   ├── Profession.php        ← Data profesi + bobot vektor
│   │   ├── Question.php          ← Bank soal (176 soal IRT)
│   │   ├── Feedback.php          ← Feedback umum
│   │   └── IdentityToken.php     ← Token link session ↔ user
│   └── Services/                 ← LAPISAN BUSINESS LOGIC
│       ├── EngineService.php           ← SPK Hybrid PM-SAW V10
│       ├── GeminiService.php           ← Integrasi Gemini AI
│       ├── InsightService.php          ← Generate insight psikologis
│       ├── CareerPathService.php       ← Peta karir & pendidikan
│       ├── PersonalProfileService.php  ← Profil kepribadian Big Five
│       ├── ExplanationService.php      ← Penjelasan naratif
│       ├── ScenarioService.php         ← Skenario karir masa depan
│       ├── DecisionService.php         ← Dukungan keputusan
│       ├── ScoringService.php          ← Kalkulasi skor
│       ├── IRTAdaptiveEngineService.php← Engine adaptif IRT
│       ├── StratifiedRandomAssessmentService.php ← Sampling soal
│       ├── IdentityResolverService.php ← Resolusi identitas
│       ├── IdentityLinkingService.php  ← Link session ke akun
│       ├── IdentityTokenService.php    ← Manajemen token
│       ├── AssessmentResultService.php ← CRUD hasil asesmen
│       ├── AnalyticsService.php        ← Analitik dashboard admin
│       └── AccessPolicyService.php     ← Kontrol akses
├── database/
│   ├── migrations/ (21 file)          ← Skema database lengkap
│   └── seeders/
│       ├── QuestionSeeder.php  ← 176 soal psikometrik
│       └── ProfessionSeeder.php← Data kamus profesi
├── resources/views/
│   ├── welcome.blade.php       ← Landing page
│   ├── auth/login.blade.php    ← Form identitas siswa
│   ├── assessment/test.blade.php ← Halaman pengerjaan soal
│   ├── results.blade.php       ← Hasil asesmen lengkap
│   ├── psikometrik.blade.php   ← Tab profil psikologis
│   ├── peta-profesi.blade.php  ← Tab rekomendasi profesi
│   ├── peta-pendidikan.blade.php ← Tab jalur pendidikan
│   ├── pengembangan-diri.blade.php ← Tab pengembangan diri
│   ├── admin/dashboard.blade.php ← Dashboard admin
│   └── pdf/                    ← Template PDF untuk cetak
└── routes/web.php              ← 261 baris routing lengkap
```

---

## 4. ALUR SISTEM (USER FLOW)

```
[Landing Page /]
     ↓
[Form Identitas /login]
 - Nama, WA, Email
 - Tipe: Siswa SMK / Mahasiswa / Pekerja / Anonim
 - Info Sekolah, Jurusan, Kelas
     ↓ (Session + DB Identity disimpan)
[Pilih Mode Asesmen /assessment]
 - Trial (20 soal - StratifiedRandom)
 - Cepat (40 soal - Random)
 - Normal (176 soal - Full IRT)
     ↓
[Pengerjaan Soal - Likert Scale 1-5]
     ↓
[POST /assessment/run]
     → ScoringService (kalkulasi raw scores)
     → EngineService.run() [SPK Hybrid PM-SAW V10]
        ├─ Profile Matching (RIASEC + Big Five) → 70%
        │    Core Factor (RIASEC) 60% + Secondary Factor (Big Five) 40%
        └─ SAW (Environment + Work Values) → 30%
     → AssessmentResultService (simpan ke DB)
     → GeminiService (generate narasi AI - async/cached)
     ↓
[Halaman Hasil /assessment/result/{id}]
 ├─ Tab: Psikometrik (/psikometrik)
 ├─ Tab: Peta Profesi (/peta-profesi)
 ├─ Tab: Peta Pendidikan (/peta-pendidikan)
 └─ Tab: Pengembangan Diri (/pengembangan-diri)
     ↓
[Export PDF /laporan-lengkap/pdf]
     ↓
[Feedback /feedback/submit]
```

---

## 5. ALGORITMA SPK (INTI SISTEM)

### Algoritma: Hybrid PM-SAW V10

```
INPUT:
  - trait[]      → Big Five (5 dimensi, skala 0-1)
  - riasec[]     → RIASEC (6 dimensi, skala 0-1)
  - environment[]→ Preferensi Lingkungan (6 dimensi, skala 0-1)
  - work_values[]→ Nilai Kerja (6 dimensi, skala 0-1)

PROSES:
  FASE 1 - Profile Matching (GAP Method, bobot 70%):
    - Core Factor (CF) = RIASEC → 60% dari PM
    - Secondary Factor (SF) = Big Five → 40% dari PM
    - GAP = user_scale - profesi_scale (skala 1-5)
    - Konversi GAP → Bobot (tabel standar: gap=0 → 5.0, gap=-1 → 4.0, dst)
    - PM_Score = (0.6 × NCF) + (0.4 × NSF)   [skala 1-5]
    - PM_Normalized = PM_Score / 5.0

  FASE 2 - SAW (Simple Additive Weighting, bobot 30%):
    - Similarity = 1 - |user_val - profesi_val|
    - SAW_Score = (0.5 × Env_Similarity) + (0.5 × WorkValues_Similarity)

  FASE 3 - Final Score:
    FinalScore = (0.7 × PM_Normalized) + (0.3 × SAW_Score)
    Output: Skala 0-100%

OUTPUT:
  - Top 3 profesi rekomendasi (dengan % kecocokan)
  - Detail breakdown (PM %, SAW %, raw scores)
  - Metadata profesi (domain, jalur akademik)
```

---

## 6. SKEMA DATABASE

| Tabel | Fungsi | Relasi Kunci |
|---|---|---|
| `users` | Admin/Operator login | - |
| `identities` | Profil siswa (session-based) | session_id |
| `assessment_profiles` | Detail profil siswa | session_key |
| `assessment_results` | Hasil asesmen + scores JSON | identity_id, user_id |
| `assessment_feedbacks` | Feedback siswa pasca asesmen | assessment_result_id |
| `feedbacks` | Feedback umum | - |
| `professions` | Kamus profesi + vektor bobot | - |
| `questions` | Bank soal IRT (176 soal) | - |
| `identity_tokens` | Token link session → user | identity_id, user_id |
| `cache`, `jobs`, `sessions` | Laravel internal | - |

### Kolom Kunci `assessment_results`:
```sql
id, user_id, session_id, assessment_version, domain,
input_trait (JSON), input_riasec (JSON), input_environment (JSON),
weights (JSON), result_top_n (JSON), result_scores (JSON),
top_score, narasi_json, feedback_*, metadata (JSON),
identity_id, created_at, updated_at
```

---

## 7. INTEGRASI AI (GEMINI)

- **Model:** `gemini-1.5-flash`
- **Trigger:** Setelah asesmen selesai, narasi di-generate dan di-cache
- **Output JSON:** `{ summary, explanation, reasons[] }`
- **Bahasa:** Indonesia (gaya Gen-Z yang sopan)
- **Fallback:** Narasi statis jika API gagal/tidak dikonfigurasi
- **Config:** `GEMINI_API_KEY` di `.env`

---

## 8. ROLES & AKSES

| Role | Akses | Login Via |
|---|---|---|
| **Admin** | Dashboard analitik, semua data siswa, export laporan | Laravel Auth (users table + role=admin) |
| **Operator/Guru** | Lihat hasil siswa, cetak laporan per siswa | Laravel Auth (users table + role=operator) |
| **Siswa** | Isi asesmen, lihat hasil diri sendiri, cetak laporan | Session-based (identities table) |
| **Anonim** | Isi asesmen, lihat hasil sementara | Session-based (tanpa data identitas) |

---

## 9. FITUR YANG SUDAH ADA (READY)

- ✅ Form identitas siswa (multi-tipe)
- ✅ Bank soal 176 soal (Big Five + RIASEC + Environment + Work Values)
- ✅ 3 mode asesmen (Trial 20 soal / Cepat 40 soal / Normal 176 soal)
- ✅ Engine SPK Hybrid PM-SAW V10
- ✅ Integrasi Gemini AI (narasi personal)
- ✅ 4 tab hasil: Psikometrik, Peta Profesi, Peta Pendidikan, Pengembangan Diri
- ✅ Export PDF per siswa (laporan lengkap)
- ✅ Dashboard Admin (analitik, top profesi, distribusi RIASEC)
- ✅ Sistem feedback siswa
- ✅ Health check endpoint (`/health`)
- ✅ Route untuk deploy (`deploy.ps1`, `deploy.sh`)
- ✅ Kamus Profesi 60+ profesi dari 6 domain

## 10. ROADMAP PENGEMBANGAN (EDUTALENT V2)

- [ ] Tambah domain profesi (Lingkungan & SDA, Transportasi, R&D, Olahraga)
- [ ] Chatbot konsultasi karir interaktif (berbasis hasil asesmen di DB)
- [ ] Ekspor laporan keseluruhan untuk Admin (Excel/PDF semua siswa)
- [ ] Fitur perbandingan antar siswa (untuk konselor)
- [ ] Multi-sekolah / multi-tenant
- [ ] Notifikasi WhatsApp (via WA API)
- [ ] Model SPK matematis yang lebih kompleks (IRT full adaptif)

---

*Blueprint ini dibuat otomatis berdasarkan analisis kode sumber Shiro_Asesmen v1 pada 2026-08-23.*
*Digunakan sebagai referensi utama pengembangan EduTalent SMK Budi Karya Natar.*
