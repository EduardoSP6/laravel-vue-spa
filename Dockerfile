FROM php:7.2-fpm

ARG APP_DIR=/var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    openssh-server \
    default-mysql-client \
    nodejs \
    npm \
    && apt-get autoremove --purge -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    sockets

RUN chmod 777 /run

RUN usermod -u 1000 www-data

WORKDIR $APP_DIR
RUN cd $APP_DIR

RUN chmod 755 -R *
RUN chown -R www-data:www-data *

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

USER www-data

EXPOSE 9000
