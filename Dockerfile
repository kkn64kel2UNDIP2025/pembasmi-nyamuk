FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    curl \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql intl

# Enable mod_rewrite
RUN a2enmod rewrite && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy project files
COPY . /var/www/html/

# Set proper ownership & permission
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/writable

# 🔥 Overwrite Apache site config to use public/ as root
RUN echo "<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf


EXPOSE 80
