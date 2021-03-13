FROM php:8-cli-alpine

RUN apk update
RUN apk add composer
RUN apk add nodejs nodejs-npm

RUN docker-php-ext-install pdo pdo_mysql

ENTRYPOINT [ "tail", "-f", "/dev/null" ]
