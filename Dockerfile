FROM php:8.2-apache

# Install dependensi sistem untuk ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

# Aktifkan mod_rewrite Apache untuk CodeIgniter
RUN a2enmod rewrite

# Salin semua file project ke dalam kontainer
COPY . /var/www/html/

# Atur permission
RUN chown -R www-data:www-data /var/www/html

# Aktifkan .htaccess agar routing CI4 jalan
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install

EXPOSE 80
