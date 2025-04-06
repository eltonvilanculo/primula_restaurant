FROM php:7.4-cli-alpine


RUN apk --no-cache add libzip-dev \
    && docker-php-ext-install zip \
    &&  docker-php-ext-install pdo pdo_mysql


WORKDIR /var/www/primula


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer update
# RUN php artisan key:generate

CMD [ "php","artisan","config:cache" ]



