ARG PHP_VERSION=7.3
FROM php:${PHP_VERSION}-cli

RUN apt update && apt install -y git libzip-dev zip && docker-php-ext-install zip

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pecl install pcov && docker-php-ext-enable pcov; fi

# Install composer to manage PHP dependencies
RUN curl https://getcomposer.org/download/1.9.1/composer.phar -o /usr/local/sbin/composer
RUN chmod +x /usr/local/sbin/composer
RUN composer self-update

WORKDIR /app
