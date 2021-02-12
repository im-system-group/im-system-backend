FROM php:8.0-fpm

COPY . /var/www

COPY build/php/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    curl

#&& apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl fileinfo opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --prefer-dist --no-progress --no-suggest

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/public \
        /var/www/bootstrap/cache

RUN cp .env.example .env

RUN php artisan key:generate && php artisan storage:link && php artisan optimize

USER www-data

EXPOSE 9000
ENTRYPOINT ["php-fpm", "-F"]