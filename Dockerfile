FROM dunglas/frankenphp:latest

# Install PHP extensions
RUN install-php-extensions \
    bcmath \
    bz2 \
    calendar \
    exif \
    ffi \
    gd \
    gettext \
    gmp \
    intl \
    mysqli \
    pcntl \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    shmop \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    zip \
    opcache

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Run Laravel optimizations and cache commands
RUN php artisan storage:link && \
    php artisan optimize:clear && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache



# Set the entry point for Laravel Octane
ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8015"]
