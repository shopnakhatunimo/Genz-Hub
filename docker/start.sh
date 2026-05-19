#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

if [ -z "$(grep '^APP_KEY=.\+' .env)" ]; then
    php artisan key:generate --force
fi

mkdir -p database
touch database/database.sqlite

php artisan storage:link --force 2>/dev/null || true
php artisan migrate --force --no-interaction 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
