FROM php:8.3-fpm-alpine

WORKDIR /var/www

RUN apk update && apk add \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

RUN apk add --no-cache postgresql-dev && \
    docker-php-ext-install pdo pdo_pgsql
    