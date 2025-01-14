FROM php:8.2-apache

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

COPY ./app /var/www/html/

WORKDIR /var/www/html

EXPOSE 80
