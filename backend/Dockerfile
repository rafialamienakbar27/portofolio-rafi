FROM php:8.4-cli-alpine

RUN apk add --no-cache bash git zip unzip postgresql-dev oniguruma-dev libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/framework/cache storage/framework/sessions \
               storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["/bin/sh", "-c", "php artisan migrate --force && php artisan db:seed --force || true && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
