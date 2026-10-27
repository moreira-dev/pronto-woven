# Template taken from https://hub.docker.com/_/php
FROM php:8.5-cli

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN apt-get update && apt-get install -y unzip git

RUN pecl install pcov \
    && docker-php-ext-enable pcov

COPY ./composer.json ./composer.lock /usr/src/pronto/

WORKDIR /usr/src/pronto
RUN composer install

COPY ./phpunit.xml ./.php-cs-fixer.dist.php /usr/src/pronto/
COPY ./tests/ /usr/src/pronto/tests
COPY ./src/ /usr/src/pronto/src
COPY ./assets/ /usr/src/pronto/assets

# Debug sessions
# CMD [ "tail", "-f", "/dev/null" ]

ENTRYPOINT [ "php", "./src/index.php" ]
