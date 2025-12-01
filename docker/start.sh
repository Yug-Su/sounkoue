#!/bin/sh

# Generate app key if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force

# Test database connection with timeout
echo "Testing database connection..."
if timeout 30 php artisan migrate:status > /dev/null 2>&1; then
    echo "Database connected, running migrations..."
    php artisan migrate --force
else
    echo "Database connection failed, skipping migrations for now"
fi

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf