# SKILL: edutalent-db-safe
# Prosedur Aman Modifikasi Database EduTalent

## Kapan Skill Ini Digunakan
Aktifkan setiap kali user meminta modifikasi skema database, migrasi baru, atau seeding data.

## Hirarki Tabel (Referensi Cepat)

| Level | Tabel | Aksi yang Diizinkan |
|---|---|---|
| KRITIS | `questions`, `professions`, `assessment_results` | Read Only. Ubah struktur HANYA dengan approval eksplisit |
| PENTING | `identities`, `assessment_profiles`, `users` | Migrasi boleh, tapi wajib backup dulu |
| OPERASIONAL | `feedbacks`, `identity_tokens`, `cache`, `jobs` | Bebas dimodifikasi |

## Checklist Sebelum Membuat Migration Baru

- [ ] Pastikan migration tidak mempengaruhi tabel level KRITIS
- [ ] Backup data lokal (via SQLite copy atau mysqldump)
- [ ] Tulis method `down()` yang bisa mereverse perubahan
- [ ] Catat di `docs/DB_MIGRATIONS.md` dengan SQL siap pakai

## Template Migration

```php
// php artisan make:migration nama_migration
public function up(): void
{
    Schema::table('nama_tabel', function (Blueprint $table) {
        $table->string('kolom_baru')->nullable()->after('kolom_existing');
    });
}

public function down(): void
{
    Schema::table('nama_tabel', function (Blueprint $table) {
        $table->dropColumn('kolom_baru');
    });
}
```

## Seeding Data Profesi Baru

Jika menambah profesi baru ke `professions` tabel:
1. Tambahkan di `database/seeders/ProfessionSeeder.php`
2. Format vektor: `trait[]` (5 dim), `riasec[]` (6 dim), `environment[]` (6 dim), `work_values[]` (6 dim)
3. Semua nilai antara 0.0 - 1.0
4. Dokumentasikan domain profesi baru di `BLUEPRINT_EDUTALENT.md`

## Perintah Rollback Aman

```powershell
# Rollback migration terakhir saja
php artisan migrate:rollback --step=1

# Cek status semua migration
php artisan migrate:status
```
