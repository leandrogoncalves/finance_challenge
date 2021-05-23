FROM php:7.4-fpm-alpine
RUN apk --no-cache add --update \
    openssl \
    bash \
    mysql-client \
    nodejs \
    npm \
    pkgconfig \
    libzip-dev \
    libcurl \
    curl-dev \
    curl \
    vim \
    wget \
    zip \
    unzip \
    autoconf \
    g++ \
    make \
    && npm i -g pm2 \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql curl bcmath

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

WORKDIR /var/www

RUN rm -rf /var/www/html
RUN ln -s public html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
ENTRYPOINT [ "php-fpm" ]
