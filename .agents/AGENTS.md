# EduTalent Supreme Rules & AI Global Instructions

This file defines the project-scoped rules and instructions for all AI agents working on the **EduTalent SMK Budi Karya Natar** project.

> **Referensi Blueprint:** Baca `BLUEPRINT_EDUTALENT.md` di root proyek untuk memahami arsitektur, alur, dan struktur proyek secara menyeluruh sebelum mengerjakan tugas apapun.

---

## 1. STANDAR DOKUMENTASI WAJIB (MANDATORY LOGGING)

Setiap kali AI memodifikasi kode, memperbarui logika, atau membuat skrip operasional, AI **WAJIB** mendokumentasikannya di file-file berikut:

1. **`CHANGELOG.md` (Log Kronologis Lokal)**
   - Catat apa yang diubah, ditambahkan, atau diperbaiki beserta tanggal dan versi.
   - **KRONOLOGIS NON-KODE (WAJIB):** Pencatatan juga **WAJIB** dilakukan untuk sesi diskusi tanpa modifikasi kode (seperti audit, analisa arsitektur, perencanaan fitur). Dokumentasikan hasil laporan, alasan (*why*), dan garis waktunya ke dalam Changelog.

2. **`ENGINEERING_NOTES.md` (Catatan Teknis EduTalent)**
   - Setiap kali AI menemukan pola desain yang baik (seperti cara EngineService meng-cache data profesi, atau pola Service injection di AssessmentController), AI **WAJIB** mencatat temuannya.
   - Begitu pula jika menemukan *anti-pattern* atau potensi *bug*, catat agar tidak terulang.

3. **`docs/DB_MIGRATIONS.md` (Log Migrasi Database)**
   - Setiap perubahan struktur database (DDL) WAJIB dicatat di file ini dengan query SQL yang siap dieksekusi untuk proses deployment ke produksi.

---

## 2. ATURAN DEVELOPER & SELF-AUDIT

1. **Baca Dulu, Kode Belakangan:** Jika ragu atau kurang konteks (struktur database, relasi model, logika service), baca file-file yang relevan di repositori sebelum menebak atau bertanya ke user. Mulai dari `BLUEPRINT_EDUTALENT.md` → `routes/web.php` → Controller yang relevan → Service yang dipanggil.
2. **Verifikasi Pasca-Perubahan:** Selalu lakukan *self-audit* dan verifikasi dampak kode yang diubah terhadap file lain. Jangan lapor selesai sebelum verifikasi 100% sukses.
3. **Link File yang Bisa Diklik:** Selalu format referensi path file/folder sebagai link yang bisa diklik menggunakan absolute path: `[nama_file.php](file:///d:/path/to/file.php)`.
4. **File Sementara (Scratch):**
   - File debug/testing sementara WAJIB disimpan di folder `scratch/` di root proyek.
   - DILARANG membuat file `*.php`, `*.sql`, `*.txt` sementara langsung di folder root atau di dalam `app/`.
   - Hapus file sementara setelah tugas selesai.

---

## 3. ARSITEKTUR DATABASE EDUTALENT

### Hirarki Tabel (Level Kepentingan)
1. **Level KRITIS (Jangan Ubah Struktur Tanpa Approval):**
   - `questions` → Bank soal 176 soal IRT, data utama asesmen
   - `professions` → Kamus profesi + vektor bobot SPK
   - `assessment_results` → Data hasil asesmen siswa (penelitian)

2. **Level PENTING (Butuh Review Sebelum Migrasi):**
   - `identities`, `assessment_profiles` → Profil siswa
   - `users` → Akun admin/operator

3. **Level OPERASIONAL (Bisa Dimodifikasi dengan Hati-hati):**
   - `feedbacks`, `assessment_feedbacks` → Data umpan balik
   - `identity_tokens` → Token sementara
   - `cache`, `jobs`, `sessions` → Laravel internal

### Aturan Relasi Kunci
- `assessment_results` **WAJIB** dihubungkan via `session_id` (untuk siswa anonim) ATAU `user_id` (untuk yang login).
- JANGAN query `assessment_results` langsung via `user_id` saja — selalu sertakan fallback ke `session_id`.
- `identity_id` di `assessment_results` → FK ke tabel `identities`.

---

## 4. ATURAN SPESIFIK ALGORITMA SPK

1. **JANGAN ubah bobot utama di `EngineService.php` tanpa izin eksplisit:**
   - PM (Profile Matching) = **70%** dari final score
   - SAW (Simple Additive Weighting) = **30%** dari final score
   - Core Factor RIASEC = **60%** dari PM
   - Secondary Factor Big Five = **40%** dari PM

2. **Tabel GAP Weight di `EngineService.php` adalah LOCKED:**
   - GAP 0 → 5.0, GAP -1 → 4.0, GAP 1 → 4.5, dst.
   - Ini adalah standar Profile Matching yang telah dikunci.

3. **Input Normalisasi:** Semua nilai input trait, riasec, environment, work_values adalah skala **0.0 - 1.0**. Jangan ubah range ini.

---

## 5. STANDAR UI/UX EDUTALENT

1. **DILARANG menggunakan React/Vue SPA penuh.** Arsitektur adalah Blade SSR + Alpine.js untuk interaktivitas ringan. Tujuannya agar aplikasi ringan di perangkat siswa SMK yang mungkin menggunakan HP low-end.
2. **Tailwind CSS via CDN** — tidak ada build step khusus untuk styling.
3. **Setiap halaman hasil asesmen** harus bisa di-print/export ke PDF via route `/{tab}/pdf`.
4. **Responsif Mobile-First** — siswa akan mengakses via HP.

---

## 6. PENCATATAN KESALAHAN AI (AI ERROR LOG)

Catat setiap kesalahan dan perbaikannya di `docs/AI_MISTAKES.md`:

**Format:**
```
[ERR-ET-XXX] Deskripsi Singkat
- Akar Penyebab:
- Solusi Final:
- Tanggal:
```

**Pre-flight Check:** Baca `docs/AI_MISTAKES.md` sebelum melakukan modifikasi untuk mencegah pengulangan kesalahan yang sama.

---

## 7. STANDAR GIT & DEPLOYMENT

### Konvensi Commit Message
```
feat(modul): Deskripsi fitur baru
fix(service): Deskripsi perbaikan bug
refactor(controller): Deskripsi refaktor
docs: Deskripsi pembaruan dokumentasi
```

### Alur Deployment ke Railway.app
1. **Push ke GitHub:** `git push github main`
2. **Railway auto-deploy** dari branch `main`
3. **Variabel ENV** wajib diset di Railway dashboard (tidak boleh hardcode):
   - `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`
   - `GEMINI_API_KEY`
   - `DB_CONNECTION` (sesuaikan ke MySQL jika dibutuhkan)
4. **Post-deploy:** Jalankan `php artisan migrate --force` dan `php artisan db:seed`

### Remote Repository
- **GitHub (Utama):** `https://github.com/rakhmatdedigaiasistenngoding-crypto/EduTalent-SMK-Budi-Karya`
- **Akun:** `rakhmatdedigaiasistenngoding-crypto`

---

## 8. PROTOKOL BACKUP

1. **Sebelum memodifikasi file kritis** (EngineService, AssessmentController, migrations), buat backup ke `scratch/backups/[nama_file]_[YYYYMMDD_HHMM].bak`.
2. **DILARANG membuat copy folder utuh secara mentah** — gunakan Git untuk version control.

---

## 9. PENANGANAN PERTANYAAN VS EKSEKUSI

- Jika user **bertanya/diskusi** → Jelaskan konsep dahulu, jangan langsung edit file.
- Jika user **memberi perintah eksplisit** → Eksekusi dengan memverifikasi dampak terlebih dahulu.
- Jika ada ambiguitas → Konfirmasi ke user sebelum mengeksekusi.

---

## 10. PETA SKILL & DELEGASI TUGAS

| # | Kondisi / Trigger | Skill yang Dipanggil | Lokasi |
|---|---|---|---|
| 1 | User meminta **fitur/modul baru** | `edutalent-new-feature` | `.agents/skills/edutalent-new-feature/SKILL.md` |
| 2 | User meminta **push/deploy ke Railway** | `edutalent-safe-release` | `.agents/skills/edutalent-safe-release/SKILL.md` |
| 3 | User meminta **migrasi/modifikasi database** | `edutalent-db-safe` | `.agents/skills/edutalent-db-safe/SKILL.md` |

---

## 11. KONTEKS PROYEK (WAJIB DIINGAT)

- **Nama Proyek:** EduTalent SMK Budi Karya Natar
- **Target Pengguna Utama:** Siswa SMK (usia 15-18 tahun)
- **Pengguna Admin:** Guru BK / Konselor / Operator Sekolah
- **Diadaptasi dari:** ShiroPathEdu / Shiro_Asesmen (proyek riset sebelumnya)
- **Bahasa UI:** Indonesia (Bahasa Indonesia yang ramah dan tidak kaku)
- **Platform Hosting:** Railway.app (primer) → Hostinger (jangka panjang)
- **Database Lokal:** SQLite | **Database Produksi:** MySQL (rekomendasi)

---

## 12. ATURAN RESPON (ANSWER ONLY & EXPLICIT REPLY)

1. **Jawab Dulu, Eksekusi Belakangan:** Jika user mengandung pertanyaan ("?"), jawab semua pertanyaan secara eksplisit SEBELUM memanggil tool eksekusi apapun.
2. **Urutan Berdasarkan Nomor:** Jika user menggunakan penomoran (1, 2, 3), respons WAJIB berurutan sesuai nomor.
3. **Tidak Ada Eksekusi Tanpa Perintah:** Jika user hanya bertanya tanpa perintah eksplisit untuk mengubah kode, AI DILARANG mengeksekusi perubahan file.
