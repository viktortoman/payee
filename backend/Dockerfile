FROM php:8.3-fpm

# Telepítéshez szükséges csomagok
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# PHP kiterjesztés telepítő letöltése és futtatása
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
    pdo \
    pdo_mysql \
    zip \
    xml \
    dom \
    xmlreader \
    xmlwriter \
    gd \
    iconv \
    simplexml \
    xsl \
    intl \
    mbstring \
    exif \
    sockets \
    bz2 \
    opcache \
    zlib \
    sodium

# Composer telepítése
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer config --global allow-plugins true

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-interaction --no-progress --no-scripts --prefer-dist && composer update --no-interaction --no-progress --no-scripts --prefer-dist && composer dump-autoload --optimize

CMD php artisan serve --host=0.0.0.0 --port=8000
