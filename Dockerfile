FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev \
    zip unzip curl git libpng-dev libonig-dev libxml2-dev libzip-dev \
    libjpeg-dev libfreetype6-dev libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos el entrypoint y lo hacemos ejecutable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Reemplazamos el CMD estándar por nuestro entrypoint
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
