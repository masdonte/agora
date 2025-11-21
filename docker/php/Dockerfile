FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libonig-dev libxml2-dev libzip-dev zip unzip git curl \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

RUN a2enmod rewrite

COPY apache/default.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
