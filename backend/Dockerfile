# =====================================================
# Laravel Production Image — for Railway/Render/Fly.io
# =====================================================
FROM php:8.3-fpm-alpine AS base

# System deps
RUN apk add --no-cache \
    bash \
    git \
    icu-dev \
    libzip-dev \
    nginx \
    oniguruma-dev \
    postgresql-dev \
    supervisor \
    zip

# PHP extensions
RUN docker-php-ext-install \
    bcmath \
    intl \
    mbstring \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer first for layer caching
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy source
COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Nginx + PHP-FPM config
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
