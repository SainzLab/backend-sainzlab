#!/bin/sh

# Jalankan cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# (Opsional) Jalankan migrasi database otomatis setiap deploy
# php artisan migrate --force

# Jalankan PHP-FPM (Background) dan Nginx (Foreground)
php-fpm -D && nginx -g "daemon off;"
