# syntax = docker/dockerfile:experimental

FROM php:7.4-apache
RUN --mount=type=secret,id=auto-devops-build-secrets . /run/secrets/auto-devops-build-secrets && $COMMAND

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo
WORKDIR /app
COPY . /app

RUN echo $PRODUCTION_ENV > .env

RUN composer install --optimize-autoloader --no-dev
RUN php artisan config:cache


COPY vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80
