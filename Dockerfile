# Base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip \
    libzip-dev nodejs npm netcat-openbsd sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# -----------------------------
# 1. Copy composer files + .env first for package discovery
# -----------------------------
COPY composer.json composer.lock ./

# Install PHP dependencies, skip scripts to avoid errors
RUN composer install --no-interaction --optimize-autoloader --no-scripts

# -----------------------------
# 2. Copy Node config first to leverage Docker cache
# -----------------------------
COPY package.json package-lock.json vite.config.js ./

# -----------------------------
# 3. Copy the rest of the Laravel app
# -----------------------------
COPY . .

# Install Node dependencies
RUN npm install
# -----------------------------
# 4. Build Vite assets (now all files exist)
# -----------------------------
RUN npm run build

# -----------------------------
# 5. Fix Laravel permissions
# -----------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -----------------------------
# 6. Copy entrypoint
# -----------------------------
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
