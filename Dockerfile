FROM dunglas/frankenphp:php8.4-alpine

RUN install-php-extensions \
    pcntl \
    pdo \
    pdo_pgsql \
    pgsql \
    intl
