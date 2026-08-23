# SKILL: edutalent-new-feature
# Prosedur Standar Pembuatan Fitur/Modul Baru di EduTalent

## Kapan Skill Ini Digunakan
Aktifkan skill ini setiap kali user meminta membuat fitur baru, controller baru, service baru, atau halaman view baru.

## Checklist Wajib Sebelum Mulai

- [ ] Baca `BLUEPRINT_EDUTALENT.md` untuk memastikan fitur tidak bertabrakan dengan arsitektur yang ada
- [ ] Baca `CHANGELOG.md` untuk konteks perkembangan terakhir
- [ ] Baca `docs/AI_MISTAKES.md` untuk mencegah pengulangan kesalahan
- [ ] Konfirmasi kepada user: fitur ini masuk ke module mana? (Assessment / Admin / Auth / Hasil)

## Standar Pembuatan Fitur Baru

### 1. Service Layer (Business Logic)
- Buat Service baru di `app/Services/NamaService.php`
- Inject Service via Constructor DI di Controller
- JANGAN tulis logika bisnis langsung di Controller

### 2. Controller
- Buat di `app/Http/Controllers/NamaController.php`
- Daftarkan route di `routes/web.php`
- Tambahkan middleware yang sesuai (`auth`, `admin`, `throttle`)

### 3. View (Blade)
- Buat di `resources/views/nama-modul/`
- Gunakan Alpine.js untuk interaktivitas (BUKAN React/Vue)
- Pastikan responsif untuk mobile

### 4. Database (jika perlu)
- Buat migration baru: `php artisan make:migration nama_migration`
- Catat perubahan di `docs/DB_MIGRATIONS.md`
- JANGAN modifikasi migration yang sudah dijalankan

### 5. Dokumentasi
- Update `CHANGELOG.md` dengan detail fitur
- Update `BLUEPRINT_EDUTALENT.md` jika ada perubahan arsitektur

## Template Commit Message
```
feat(nama-modul): Deskripsi fitur yang ditambahkan
```
