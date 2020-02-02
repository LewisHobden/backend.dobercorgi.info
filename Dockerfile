# syntax = docker/dockerfile:experimental
FROM gcr.io/nomadic-groove-240312/php7-nginx:latest
    
RUN --mount=type=secret,id=auto-devops-build-secrets . /run/secrets/auto-devops-build-secrets && $COMMAND && \
printf '$PRODUCTION_ENV' >> .env

COPY . /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN apk add nodejs nodejs-npm
RUN npm install
RUN composer install