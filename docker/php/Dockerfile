FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
        vim \
        cron \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libonig-dev \
        libpq-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libwebp-dev \
        supervisor \
        libzip-dev \
    && pecl install xdebug-3.4.1 \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip opcache sockets  \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable xdebug


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/custom.ini

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

WORKDIR /var/www

EXPOSE 9000

CMD bash -c "cron && php-fpm"
