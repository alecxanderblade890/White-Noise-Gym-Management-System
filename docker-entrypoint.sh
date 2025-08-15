#!/bin/sh
set -e

# Wait for MySQL
echo "Waiting for MySQL..."
until nc -z -v -w30 "$DB_HOST" "$DB_PORT"; do
  echo "Waiting for database connection..."
  sleep 2
done

# Run package discovery now that app is fully copied
php artisan package:discover --ansi

# Clear and cache configs
php artisan config:clear
php artisan config:cache
php artisan route:cache

# # Run migrations (optional)
# php artisan migrate --force --seed

# Start PHP-FPM
exec php-fpm
