#!/bin/sh

# Use example env as base
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Using .env.example as base"
fi

# Generate app key if not exists
php artisan key:generate --force

# Create migrations table and run migrations
echo "\nSetting up database..."
php artisan migrate:install --force
echo "Running migrations..."
php artisan migrate --force

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf