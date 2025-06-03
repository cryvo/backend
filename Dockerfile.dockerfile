FROM php:8.1-fpm

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
