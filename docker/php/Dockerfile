FROM namoshek/php-mssql:8.2-fpm
# https://github.com/Namoshek/docker-php-mssql

RUN apt-get update \
  && apt-get install -y vim wget libicu-dev libpng-dev ruby curl \
     libsqlite3-dev libjpeg-dev libfreetype6-dev libonig-dev \
  && docker-php-ext-install pdo_mysql mysqli intl gd opcache \
  && docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

RUN apt-get install -y imagemagick libmagickwand-dev \
 && pecl install imagick \
 && docker-php-ext-enable imagick

RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer
