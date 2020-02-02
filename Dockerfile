ARG PRODUCTION_ENV

FROM gcr.io/nomadic-groove-240312/php7-nginx:latest

COPY . /var/www/
WORKDIR /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN touch .env
RUN base64 -d ${PRODUCTION_ENV} > .env

RUN apk add nodejs nodejs-npm
RUN npm install
RUN composer install 