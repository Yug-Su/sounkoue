#!/bin/sh

# Use production env if exists, otherwise use example
if [ -f .env.production ]; then
    cp .env.production .env
elif [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not exists
php artisan key:generate --force

# Wait for database with retries
echo "Waiting for database connection..."
for i in $(seq 1 30); do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "Database connected successfully!"
        php artisan migrate --force
        break
    else
        echo "Attempt $i: Database not ready, waiting 2 seconds..."
        sleep 2
    fi
done

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf