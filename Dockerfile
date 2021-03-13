FROM gcr.io/nomadic-groove-240312/php7-nginx:latest

ARG PRODUCTION_ENV

COPY . /var/www/
WORKDIR /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN touch .env
RUN echo ${PRODUCTION_ENV} | base64 -d > .env

RUN apk add nodejs nodejs-npm
RUN composer install

RUN npm install
RUN npm run production
