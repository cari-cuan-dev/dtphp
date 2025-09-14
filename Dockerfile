FROM dunglas/frankenphp:php8.4-alpine

RUN install-php-extensions \
    pcntl \
    pdo \
    pdo_pgsql \
    pgsql \
    intl


RUN apk add --no-cache nodejs npm
RUN apk add --no-cache chromium nss freetype-dev harfbuzz

ENV LARAVEL_PDF_NODE_BINARY=/usr/bin/node \
    LARAVEL_PDF_NPM_BINARY=/usr/bin/npm \
    LARAVEL_PDF_CHROME_PATH=/usr/bin/chromium
