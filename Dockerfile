# FROM dunglas/frankenphp:latest

# # Install PHP extensions
# RUN install-php-extensions \
#     bcmath \
#     bz2 \
#     calendar \
#     exif \
#     ffi \
#     gd \
#     gettext \
#     gmp \
#     intl \
#     mysqli \
#     pcntl \
#     pdo_mysql \
#     pdo_pgsql \
#     pgsql \
#     shmop \
#     soap \
#     sockets \
#     sysvmsg \
#     sysvsem \
#     sysvshm \
#     zip \
#     opcache

# # Set working directory
# WORKDIR /app

# # Copy application files
# COPY . /app

# # Run Laravel optimizations and cache commands
# RUN php artisan storage:link && \
#     php artisan optimize:clear && \
#     php artisan route:cache && \
#     php artisan view:cache && \
#     php artisan event:cache



# # Set the entry point for Laravel Octane
# ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8015"]

# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install dependensi yang dibutuhkan untuk Laravel
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    docker-php-ext-install pdo pdo_mysql

# Set working directory ke /var/www/html
WORKDIR /var/www/html

# Salin semua file ke dalam container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permissions untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set port yang digunakan oleh aplikasi
EXPOSE 80

# Jalankan Apache di background
CMD ["apache2-foreground"]
