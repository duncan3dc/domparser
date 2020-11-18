ARG PHP_VERSION=7.2
FROM php:${PHP_VERSION}-cli

RUN apt update && apt install -y git libzip-dev zip && docker-php-ext-install zip

# Install pickle to help manage extensions
RUN curl --location https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar -o /usr/local/sbin/pickle
RUN chmod +x /usr/local/sbin/pickle

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pickle install pcov && docker-php-ext-enable pcov; fi

# Install composer to manage PHP dependencies
RUN curl https://getcomposer.org/download/1.9.1/composer.phar -o /usr/local/sbin/composer
RUN chmod +x /usr/local/sbin/composer
RUN composer self-update

WORKDIR /app
