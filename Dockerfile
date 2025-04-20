FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev \
    zip unzip curl git libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
