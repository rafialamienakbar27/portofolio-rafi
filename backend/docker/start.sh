#!/bin/sh
set -e
cd /app
for i in $(seq 1 30); do
  php artisan migrate --force --no-interaction && break
  sleep 2
done
php artisan db:seed --force --no-interaction || true
php artisan config:cache || true
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
