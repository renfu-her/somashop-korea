#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

php artisan down || true

git pull --ff-only

composer install --no-dev --optimize-autoloader --no-interaction

npm ci
npm run build

php artisan migrate --force
php artisan storage:link || true

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan up

echo "Deploy complete."
