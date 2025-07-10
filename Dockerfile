FROM php:8.2-apache-slim

# Install ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Aktifkan mod_rewrite untuk CI4
RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Salin project ke kontainer
COPY . /var/www/html/

WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install

# Set permission
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
