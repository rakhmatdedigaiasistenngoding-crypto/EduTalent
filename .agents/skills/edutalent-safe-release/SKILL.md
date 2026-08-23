# SKILL: edutalent-safe-release
# Prosedur Aman Deploy ke Railway.app / GitHub

## Kapan Skill Ini Digunakan
Aktifkan setiap kali user meminta push ke GitHub, deploy ke Railway, atau rilis ke produksi.

## Checklist Pre-Release (WAJIB)

- [ ] Pastikan tidak ada `dd()`, `var_dump()`, atau `print_r()` di kode
- [ ] Pastikan tidak ada kredensial API hardcoded di file PHP/Blade
- [ ] Pastikan `.env` tidak ikut di-commit (cek `.gitignore`)
- [ ] Pastikan `APP_DEBUG=false` di environment produksi
- [ ] Pastikan semua migration baru sudah didokumentasikan di `docs/DB_MIGRATIONS.md`
- [ ] Update `CHANGELOG.md` dengan rangkuman perubahan rilis ini

## Alur Push ke GitHub

```powershell
# 1. Cek status
git status

# 2. Stage semua perubahan
git add .

# 3. Commit terstruktur
git commit -m "feat(modul): Deskripsi perubahan rilis"

# 4. Push ke GitHub
git push github main
```

## Variabel ENV yang Wajib Diset di Railway

Setelah push berhasil, pastikan variabel berikut sudah diset di Railway Dashboard:
- `APP_NAME=EduTalent`
- `APP_ENV=production`
- `APP_KEY=` (generate via `php artisan key:generate --show`)
- `APP_DEBUG=false`
- `APP_URL=https://[nama-app].railway.app`
- `DB_CONNECTION=mysql` (Railway menyediakan MySQL)
- `DB_HOST=`, `DB_PORT=`, `DB_DATABASE=`, `DB_USERNAME=`, `DB_PASSWORD=` (dari Railway)
- `GEMINI_API_KEY=`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`

## Post-Deploy Commands (via Railway Console atau Procfile)

```bash
php artisan migrate --force
php artisan db:seed --class=QuestionSeeder
php artisan db:seed --class=ProfessionSeeder
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
