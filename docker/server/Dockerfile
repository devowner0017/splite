FROM php:7.4-apache

MAINTAINER Gevorg Melkumyan <gevorg.melkumyan@polymorphic.io>

COPY ./config/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libxml2-dev vim
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug-2.8.1
RUN docker-php-ext-enable xdebug
RUN chown -R www-data:www-data /var/www/html
RUN apt-get install -y vim
RUN a2enmod rewrite
RUN service apache2 restart
RUN cd --
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y git

COPY ./mods-available/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

EXPOSE 80
EXPOSE 9000
