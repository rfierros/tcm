#!/bin/sh
set -e

# crea la carpeta y el sqlite si falta
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database

exec php-fpm
