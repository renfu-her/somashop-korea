#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

php artisan down || true
trap 'php artisan up' EXIT

git pull --ff-only

composer install --no-dev --optimize-autoloader --no-interaction

if command -v npm >/dev/null 2>&1; then
    npm ci
    npm run build
else
    echo "npm not found; skipping asset build."
fi

php artisan migrate --force
php artisan storage:link || true

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy complete."
