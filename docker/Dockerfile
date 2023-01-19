FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip gnupg \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/appoitment_app


# create docker sudo user
RUN useradd -ms /bin/bash docker && adduser docker sudo

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer &&\
    chmod +x /usr/local/bin/composer

# install node.js
RUN curl -sL https://deb.nodesource.com/setup_19.x | bash - && \
  	apt-get install -y nodejs
RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN curl -sS https://get.symfony.com/cli/installer | bash
