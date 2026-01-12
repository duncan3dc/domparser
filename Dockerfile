ARG PHP_VERSION=7.3
FROM php:${PHP_VERSION}-cli

RUN apt update && apt install -y git libzip-dev zip && docker-php-ext-install zip

# Install pickle to help manage extensions
RUN curl --location https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar -o /usr/local/sbin/pickle
RUN chmod +x /usr/local/sbin/pickle

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pickle install pcov && docker-php-ext-enable pcov; fi

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
