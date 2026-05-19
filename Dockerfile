FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json ./
RUN npm install

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./

RUN mkdir -p public && npm run build

FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    sqlite-dev \
    postgresql-dev \
    supervisor \
    bash

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    zip \
    gd \
    bcmath \
    pcntl

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY --from=node-builder /app/public/build ./public/build

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-dev

RUN cp .env.example .env \
    && php artisan key:generate --force \
    && mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && php artisan storage:link --force

RUN mkdir -p /var/log/supervisor \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
