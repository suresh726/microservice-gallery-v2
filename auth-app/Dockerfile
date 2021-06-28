FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Copy compose.json and composer.lock in working directory
COPY composer.lock composer.json /var/www/html/


# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing directory
COPY . /var/www/html

# Change the ownership of the directory
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN composer install

CMD php artisan serve --host=0.0.0.0

EXPOSE 8000
