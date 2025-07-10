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

# Set document root ke public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ubah config Apache agar pakai folder public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf \
    && echo "DocumentRoot /var/www/html/public" >> /etc/apache2/apache2.conf

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/writable

EXPOSE 80