FROM php:8.1.6-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add \
    build-base \
    git \
    curl \
    zip \
    supervisor \
    libzip-dev \
    libpq-dev \
    postgresql \
    postgresql-client \
    unzip \
    nano

RUN docker-php-ext-configure pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app

COPY supervisord.conf /etc/supervisord.conf
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
