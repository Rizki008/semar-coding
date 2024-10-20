FROM php:8.0-fpm
WORKDIR /code
RUN docker-php-ext-install mysqli
