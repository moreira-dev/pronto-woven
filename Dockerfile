# Template taken from https://hub.docker.com/_/php
FROM php:8.5-cli

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN apt-get update && apt-get install -y unzip git

COPY ./composer.json ./composer.lock /usr/src/pronto/
COPY ./src/ /usr/src/pronto/src
COPY ./assets/ /usr/src/pronto/assets

WORKDIR /usr/src/pronto
RUN composer install

# Debug sessions
CMD [ "tail", "-f", "/dev/null" ]

# CMD [ "php", "./src/index.php" ]
