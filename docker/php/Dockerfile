FROM php:7.2-fpm

RUN mkdir /usr/share/man/man1
ADD composer-setup.sh /composer-setup.sh
RUN apt-get update
RUN apt-get install -y wget git zip unzip libpq-dev zlib1g-dev

RUN chmod +x /composer-setup.sh
RUN /composer-setup.sh
RUN rm /composer-setup.sh && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_pgsql zip pcntl

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/html
