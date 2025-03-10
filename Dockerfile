FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apk update && apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    shadow \
    supervisor \
    nginx \
    php82-bcmath \
    php82-ctype \
    php82-fileinfo \
    php82-gd \
    php82-iconv \
    php82-intl \
    php82-json \
    php82-mbstring \
    php82-mysqlnd \
    php82-opcache \
    php82-openssl \
    php82-pdo_mysql \
    php82-pdo_pgsql \
    php82-pdo_sqlite \
    php82-pgsql \
    php82-tokenizer \
    php82-xml \
    php82-zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy application files
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy .env.example to .env and generate app key
# RUN cp .env .
RUN php artisan key:generate --no-interaction

# Set age and bootstrap cache permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Generate configuration cache
RUN php artisan config:cache

# Generate route cache
RUN php artisan route:cache

# Expose port for php artisan serve
EXPOSE 8000

# Command to run the Laravel application using php artisan serve
CMD ["npm", "run", "start"]