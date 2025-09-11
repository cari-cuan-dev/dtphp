FROM dunglas/frankenphp:php8.4-alpine

RUN install-php-extensions \
    pcntl \
    pdo \
    pdo_pgsql \
    pgsql

RUN install-php-extensions intl

# RUN apk add --no-cache php8-pdo_pgsql php8-pgsql
