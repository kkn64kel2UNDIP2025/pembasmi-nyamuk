FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

# Aktifkan mod_rewrite dan atur ServerName
RUN a2enmod rewrite && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ✅ Ubah DocumentRoot ke folder 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# ✅ Ubah konfigurasi Apache agar menggunakan public/
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# ✅ Salin project ke folder yang sesuai
COPY . /var/www/html/

# ✅ Atur permission
RUN chown -R www-data:www-data /var/www/html

# ✅ Jangan pakai WORKDIR — Railway akan jalankan dari root Apache
# WORKDIR /var/www/public ← HAPUS

EXPOSE 80