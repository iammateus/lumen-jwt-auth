FROM php:7.4-apache

RUN  apt-get update \
    && apt-get install nano libzip-dev libpq-dev -y \
    && pecl install zip -y \
    && pecl install xdebug -y \
    && docker-php-ext-enable zip xdebug \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && curl -s https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && a2enmod rewrite headers 

COPY ./.docker/conf/apache.conf /etc/apache2/sites-available/000-default.conf

COPY ./.docker/conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer update