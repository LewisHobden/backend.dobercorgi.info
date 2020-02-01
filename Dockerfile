# syntax = docker/dockerfile:experimental
FROM gcr.io/nomadic-groove-240312/php7-nginx:latest
    
RUN --mount=type=secret,id=auto-devops-build-secrets . /run/secrets/auto-devops-build-secrets && $COMMAND

COPY . /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN apk add nodejs nodejs-npm
RUN npm install
RUN composer install

RUN echo ${PRODUCTION_ENV} > .env
RUN echo "DB_USERNAME=${POSTGRES_USER}" >> .env
RUN echo "DB_DATABASE=${POSTGRES_DB}" >> .env
RUN echo "DB_PASSWORD=${POSTGRES_PASSWORD}" >> .env