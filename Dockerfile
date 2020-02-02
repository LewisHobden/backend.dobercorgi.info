ARG PRODUCTION_ENV

FROM gcr.io/nomadic-groove-240312/php7-nginx:latest

RUN printf '${PRODUCTION_ENV}' > .env

COPY . /var/www/
RUN chmod -Rf 777 /var/www/storage/

RUN apk add nodejs nodejs-npm
RUN npm install
RUN composer install