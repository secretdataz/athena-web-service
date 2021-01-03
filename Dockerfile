FROM php:7.4-fpm-alpine

RUN apk upgrade --update && apk add \
    git \
    libpng-dev \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd

ADD . /service
WORKDIR /service

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -S serviceuser && adduser -S serviceuser -G serviceuser
RUN mkdir -p /home/serviceuser/.composer && \
    chown -R serviceuser:serviceuser /home/serviceuser

RUN composer install
RUN php artisan key:generate
RUN php artisan migrate --force

USER serviceuser
