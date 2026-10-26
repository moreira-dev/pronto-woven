# Template taken from https://hub.docker.com/_/php
FROM php:8.5-cli
COPY ./src/ /usr/src/pronto
WORKDIR /usr/src/pronto
CMD [ "php", "./index.php" ]
