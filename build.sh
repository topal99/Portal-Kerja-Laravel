#!/usr/bin/env bash
# exit on error
set -o errexit

# Instal dependensi composer
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Compile aset frontend
npm install
npm run build

# Hapus cache lama dan buat cache baru untuk produksi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database
php artisan migrate --force