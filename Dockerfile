FROM php:8.3.4-fpm-alpine

RUN apk add --no-cache postgresql-dev msmtp perl wget procps shadow libzip libpng libjpeg-turbo libwebp freetype icu

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd \
    pgsql pdo pdo_pgsql \
    intl  \
    bcmath \
    opcache \
    exif \
    zip && \
    apk del build-essentials && rm -rf /usr/src/php*

RUN apk add --no-cache nginx wget
RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"



WORKDIR  /app
COPY composer.json .
RUN composer install --no-scripts
COPY . .

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port", "8080"]
