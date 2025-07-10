# Dockerfile aman tanpa composer
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

RUN a2enmod rewrite && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY . /var/www/
RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/public

EXPOSE 80