FROM php:8.4-fpm-alpine

RUN apt-get -y update && apt-get upgrade -y

RUN apt-get install -y \
    mariadb-client \
    build-essential \
    libpng-dev \
    libwebp-dev \
    libonig-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    libxml2-dev \
    libzip-dev \
    nano \
    iputils-ping \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    \
    # add pgsql and pdo_pgsql, if you use PostgreSQL
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl soap bcmath sockets\
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install gd \
    \
    # clean cache
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    # install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

CMD ["php-fpm"]