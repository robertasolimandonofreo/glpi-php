FROM php:8-fpm
RUN apt-get install passwd
RUN usermod -u 82 www-data \
&& groupmod -g 82 www-data
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        git \
        rsync \
        libbz2-dev \
        libcurl4-openssl-dev \
        libfreetype6-dev \ 
        libjpeg62-turbo-dev \
        libldap2-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libxpm-dev \
        libzip-dev

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ \
                                --with-jpeg=/usr/include/ \
                                --with-xpm=/usr/include/ \
                                --enable-gd-jis-conv \
    && docker-php-ext-configure mysqli -with-mysqli=mysqlnd \
    && docker-php-ext-configure pdo_mysql -with-pdo-mysql=mysqlnd \
    && docker-php-ext-install -j$(nproc) \
        bz2 \
        curl \
        exif \
        gd \
        intl \
        ldap \
        mbstring \
        mysqli \
        opcache \
        pdo \
        pdo_mysql \
        xml \
        zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && pecl install xmlrpc-beta \
    && docker-php-ext-enable xmlrpc

RUN apt-get install -y \
    wget \
    unzip 
