#!/bin/bash

echo "🔨 Building Docker image..."
docker build -t sounkoue-app .

if [ $? -ne 0 ]; then
    echo "❌ Docker build failed"
    exit 1
fi

echo "✅ Docker build successful"

echo "🧪 Testing database connection in container..."
docker run --rm -e DB_HOST=dpg-d4mun11r0fns73ah6e1g-a.oregon-postgres.render.com \
    -e DB_PORT=5432 \
    -e DB_DATABASE=sounkoue_db \
    -e DB_USERNAME=sounkoue_user \
    -e DB_PASSWORD=o1oaDCavj9OqpITOPvJtsObq1NXbgZXo \
    -e DB_CONNECTION=pgsql \
    sounkoue-app php test-db.php

echo "🚀 Starting container on port 8080..."
docker run -d -p 8080:80 \
    -e DB_HOST=dpg-d4mun11r0fns73ah6e1g-a.oregon-postgres.render.com \
    -e DB_PORT=5432 \
    -e DB_DATABASE=sounkoue_db \
    -e DB_USERNAME=sounkoue_user \
    -e DB_PASSWORD=o1oaDCavj9OqpITOPvJtsObq1NXbgZXo \
    -e DB_CONNECTION=pgsql \
    --name sounkoue-test \
    sounkoue-app

echo "Container started. Check logs with: docker logs sounkoue-test"
echo "Access app at: http://localhost:8080"
echo "Stop container with: docker stop sounkoue-test && docker rm sounkoue-test"