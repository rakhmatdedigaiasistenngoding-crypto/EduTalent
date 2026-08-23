Write-Host "🚀 Memulai proses deployment (Windows)..." -ForegroundColor Cyan

# 1. Mode Maintenance
php artisan down --refresh=15 --retry=60

# 2. Migrasi
Write-Host "📦 Menjalankan migrasi..." -ForegroundColor Yellow
php artisan migrate --force

# 3. Optimasi Cache
Write-Host "⚡ Mengoptimalkan cache..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 4. Selesai
php artisan up
Write-Host "✅ Deployment Selesai!" -ForegroundColor Green
