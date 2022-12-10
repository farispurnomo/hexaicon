FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
  libonig-dev \
  libmcrypt-dev \
  libpng-dev \
  curl
  
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gd
RUN docker-php-ext-install gettext
# RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql
