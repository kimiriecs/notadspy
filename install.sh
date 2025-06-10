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
cp .env.example .env

echo "Starting Sail containers..."
./vendor/bin/sail up -d

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

echo "All done"
