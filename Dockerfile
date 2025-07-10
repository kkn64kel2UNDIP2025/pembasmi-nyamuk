FROM php:8.2-apache

# Install dependensi sistem & ekstensi PHP yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Salin semua file proyek ke direktori web server
COPY . /var/www/html/

# Atur permission
RUN chown -R www-data:www-data /var/www/html

# Konfigurasi Apache agar .htaccess CI4 aktif
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install

EXPOSE 80