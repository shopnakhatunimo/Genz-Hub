FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json ./
RUN npm install

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public/ ./public/

RUN npm run build

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
    supervisor

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

COPY composer.json ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

COPY . .

COPY --from=node-builder /app/public/build ./public/build

RUN composer run-script post-autoload-dump || true

RUN cp .env.example .env \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan storage:link --force

RUN mkdir -p /var/log/supervisor \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
