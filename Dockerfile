FROM php:8.4-cli

# System packages required for Laravel build/runtime
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    pkg-config \
    zlib1g-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip bcmath intl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js + npm (for Vite asset build)
RUN apt-get update && apt-get install -y --no-install-recommends nodejs npm \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install PHP dependencies first (better layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

# Install JS dependencies first (better layer caching)
COPY package.json package-lock.json ./
RUN npm ci

# Copy application code
COPY . .

# Build frontend assets
RUN npm run build

# Laravel writable directories
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Render injects PORT env var
# Ensure SQLite file exists and run migrations before serving.
CMD ["sh", "-c", "mkdir -p database && touch database/database.sqlite && php artisan migrate --force --no-interaction && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
