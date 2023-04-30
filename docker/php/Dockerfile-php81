FROM php:8.1-fpm-buster

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

### sqlsrv

ENV ACCEPT_EULA=Y

# Install prerequisites required for tools and extensions installed later on.
RUN apt-get update \
    && apt-get install -y apt-transport-https gnupg2 libpng-dev libzip-dev unzip \
    && rm -rf /var/lib/apt/lists/*

# Install prerequisites for the sqlsrv and pdo_sqlsrv PHP extensions.
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && apt-get install -y msodbcsql17 mssql-tools unixodbc-dev \
    && rm -rf /var/lib/apt/lists/*

# Retrieve the script used to install PHP extensions from the source container.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

# Install required PHP extensions and all their prerequisites available via apt.
RUN chmod uga+x /usr/bin/install-php-extensions \
    && sync \
    && install-php-extensions bcmath ds exif gd intl opcache pcntl pdo_sqlsrv redis sqlsrv zip
