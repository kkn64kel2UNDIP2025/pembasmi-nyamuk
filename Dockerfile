FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install pdo pdo_pgsql

# Copy semua file project ke dalam kontainer
COPY . /var/www/html/

# Ubah permission
RUN chown -R www-data:www-data /var/www/html

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Konfigurasi apache agar support CodeIgniter .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Install composer dan dependensi
RUN apt-get update && apt-get install -y unzip curl git \
  && curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer install

EXPOSE 80
