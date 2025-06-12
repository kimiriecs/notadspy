#!/bin/bash

set -e

echo "Installing Composer dependencies..."
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

echo "Copying .env file..."
cp .env.example .env && \
    sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env && \
    sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spy/' .env

echo "Copying .env.testing file..."
cp .env.example .env.testing && \
    sed -i 's/^APP_ENV=.*/APP_ENV=testing/' .env.testing && \
    sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env && \
    sed -i 's/^DB_DATABASE=.*/DB_DATABASE=spy_testing/' .env.testing

echo "Starting Sail containers..."
./vendor/bin/sail up -d

echo -n "Waiting for MySQL to be healthy"
(
  ./vendor/bin/sail exec -T mysql sh -c '
    until mysqladmin ping -h"127.0.0.1" -p"$MYSQL_PASSWORD" --silent 2>/dev/null; do
        sleep 1
    done
  '
) &
PID=$!
while kill -0 "$PID" 2>/dev/null; do
    echo -n "."
    sleep 1
done
echo "Mysql check finished..."

echo "Generating app key..."
./vendor/bin/sail artisan key:generate

echo "Running migrations..."
./vendor/bin/sail artisan migrate

echo "Seeding database..."
./vendor/bin/sail artisan db:seed

echo "Installing npm dependencies..."
./vendor/bin/sail npm install

echo "Building frontend assets..."
./vendor/bin/sail npm run build

set -a; source .env; set +a
echo "All done"
echo "App: http://localhost:${APP_PORT}"
echo "Horizon: http://localhost:${APP_PORT}/horizon"
echo "MailPit: http://localhost:${FORWARD_MAILPIT_DASHBOARD_PORT}"
