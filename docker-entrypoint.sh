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

# Run migrations and seed only on first run
if [ ! -f "/var/www/html/first-run-complete" ]; then
    echo "First run detected - running migrations and seeding..."
    php artisan migrate:fresh --seed --force
    touch /var/www/html/first-run-complete
    echo "Migrations and seeding completed successfully"
fi

# Start PHP-FPM
exec php-fpm
