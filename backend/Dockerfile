FROM composer as code

WORKDIR /code
COPY . .
RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader

FROM php:8.0.2-fpm-alpine

# Installing required php extensions
RUN docker-php-ext-install pdo pdo_mysql opcache

RUN apk add --no-cache --update --virtual .phpize-deps autoconf g++ make
RUN wget https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar && \
    chmod +x pickle.phar && \
    mv pickle.phar /usr/local/bin/pickle
RUN pickle install apcu && docker-php-ext-enable apcu

# Installing the app
WORKDIR /code
COPY --from=code /code/ .
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY php-config/* $PHP_INI_DIR/conf.d/
