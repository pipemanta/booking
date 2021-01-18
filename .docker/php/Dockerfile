FROM php:7.3-fpm

WORKDIR /var/www

RUN apt-get update
RUN apt-get install -y git zlib1g-dev libzip-dev unzip wget
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini
RUN printf "\n" | pecl install apcu xdebug && docker-php-ext-enable xdebug apcu

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && mv composer.phar /usr/local/bin/composer

EXPOSE 9000
CMD ["php-fpm"]
