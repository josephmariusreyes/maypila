# =============================================================================
# STAGING ONLY
# =============================================================================

# STAGING
# Installs all Composer deps (including dev), copies .env.staging, and serves via artisan.
# Target with: docker build --target staging
FROM php:8.3-cli AS staging

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --optimize-autoloader

RUN cp .env.staging .env && php artisan key:generate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


# =============================================================================
# PRODUCTION ONLY
# =============================================================================

# PRODUCTION
# Installs production-only Composer deps, copies .env.production, and serves via artisan.
# Target with: docker build --target production
FROM php:8.3-cli AS production

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN cp .env.production .env && php artisan key:generate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]