FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install --no-interaction

COPY . .

RUN chown -R www-data:www-data /var/www/html