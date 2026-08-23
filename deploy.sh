#!/bin/bash
set -e

echo "🚀 Memulai proses deployment..."

# 1. Aktifkan Mode Maintenance
php artisan down --refresh=15 --retry=60 || true

# 2. Ambil kode terbaru
git pull origin main

# 3. Optimasi Composer
composer install --no-dev --optimize-autoloader

# 4. Jalankan Migrasi Database (Force)
php artisan migrate --force

# 5. Bersihkan dan Kunci Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 6. Matikan Mode Maintenance
php artisan up

echo "✅ Deployment selesai! Aplikasi kembali online."
