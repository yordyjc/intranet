FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    nano \
    curl \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-enable pdo_mysql mysqli \
    && rm -rf /var/lib/apt/lists/*
# COMPOSER INSTALATION

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer


COPY ./entrypoint.sh /usr/local/bin

RUN chmod +x /usr/local/bin/entrypoint.sh

# ENTRYPOINT /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

CMD composer update
CMD php artisan migrate

CMD ["php-fpm"]

