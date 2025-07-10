FROM php:8.2-apache

# Install sistem dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Konfigurasi Apache untuk menghindari warning FQDN
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Salin project ke direktori yang benar
COPY . /var/www/

# Atur permission
RUN chown -R www-data:www-data /var/www

# Set working directory ke /public (folder index.php CI4 berada)
WORKDIR /var/www/public

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --working-dir=/var/www

EXPOSE 80
