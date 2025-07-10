FROM php:8.2-apache

# Install dependensi sistem & PHP ekstensi
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

# Aktifkan mod_rewrite dan hilangkan warning domain
RUN a2enmod rewrite && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Salin project ke /var/www/
COPY . /var/www/

# Atur hak akses
RUN chown -R www-data:www-data /var/www

# Set direktori kerja ke dalam public/ CI4
WORKDIR /var/www/public

# Install composer dan dependency
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --working-dir=/var/www

EXPOSE 80
