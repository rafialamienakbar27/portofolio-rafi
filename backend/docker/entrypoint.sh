#!/bin/sh
set -e

cd /var/www/html

# Generate APP_KEY jika belum ada
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY kosong — generate sementara (set APP_KEY di env untuk produksi!)"
    php artisan key:generate --force
fi

# Cache configs untuk performa
php artisan config:cache || true
php artisan route:cache || true

# Tunggu DB siap, lalu migrate
echo "⏳ Menjalankan migrasi..."
php artisan migrate --force --no-interaction || echo "⚠️ migrate gagal (mungkin DB belum siap)"

# Seed hanya jika tabel kosong
if [ "$RUN_SEEDER" = "true" ]; then
    echo "🌱 Menjalankan seeder..."
    php artisan db:seed --force --no-interaction || true
fi

exec "$@"
