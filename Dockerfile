# syntax = docker/dockerfile:experimental
FROM gcr.io/nomadic-groove-240312/php7-nginx:latest
    
RUN --mount=type=secret,id=auto-devops-build-secrets . /run/secrets/auto-devops-build-secrets && $COMMAND && \
echo ${PRODUCTION_ENV} > .env && \
echo "DB_USERNAME=${POSTGRES_USER}" >> .env && \
echo "DB_DATABASE=${POSTGRES_DB}" >> .env && \
echo "DB_PASSWORD=${POSTGRES_PASSWORD}" >> .env

COPY . /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN apk add nodejs nodejs-npm
RUN npm install
RUN composer install