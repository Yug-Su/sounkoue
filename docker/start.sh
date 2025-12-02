#!/bin/sh

# Use production env if exists, otherwise use example
if [ -f .env.production ]; then
    cp .env.production .env
elif [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not exists
php artisan key:generate --force

# Debug database connection
echo "=== Database Debug Info ==="
php debug-db.php

# Wait for database with retries
echo "\nWaiting for database connection..."
for i in $(seq 1 5); do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "Database connected successfully!"
        php artisan migrate --force
        break
    else
        echo "Attempt $i: Database not ready, waiting 5 seconds..."
        if [ $i -eq 1 ]; then
            echo "First attempt failed, showing debug info:"
            php artisan migrate:status || true
        fi
        sleep 5
    fi
done

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf