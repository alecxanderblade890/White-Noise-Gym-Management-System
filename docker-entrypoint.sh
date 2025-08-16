#!/bin/sh
set -e

# Ensure SQLite database file exists and is writable
if [ "$DB_CONNECTION" = "sqlite" ]; then
    touch "$DB_DATABASE"
    chown www-data:www-data "$DB_DATABASE"
    chmod 666 "$DB_DATABASE"
    echo "SQLite database file ready at $DB_DATABASE"
fi

# Run package discovery now that app is fully copied
php artisan package:discover --ansi
php artisan config:clear
php artisan config:cache
php artisan route:cache

# Run migrations & seed only once
if [ ! -f "/var/www/html/first-run-complete" ]; then
    echo "First run detected - running migrations and seeding..."
    php artisan migrate:fresh --seed --force
    touch /var/www/html/first-run-complete
    echo "Migrations and seeding completed successfully"
fi

# Start Supervisor (which runs php-fpm + nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
