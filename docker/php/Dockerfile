FROM php:8.3-fpm-alpine

# Install system and build dependencies
RUN apk add --no-cache bash git zip unzip icu-dev oniguruma-dev libzip-dev \
    libpng-dev freetype-dev libjpeg-turbo-dev postgresql-dev $PHPIZE_DEPS

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_pgsql mbstring zip gd

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

CMD ["php-fpm"]
