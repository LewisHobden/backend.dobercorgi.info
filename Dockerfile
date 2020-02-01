# syntax = docker/dockerfile:experimental

FROM creativitykills/nginx-php-server:2.0.0
    
#RUN --mount=type=secret,id=auto-devops-build-secrets . /run/secrets/auto-devops-build-secrets && $COMMAND

COPY . /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN composer install

#RUN echo $PRODUCTION_ENV > .env

ENV PHP_VERSION 7.4
ENV LARAVEL_APP 1
ENV PRODUCTION 1