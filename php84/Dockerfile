FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libssl-dev \
    nano \
    curl \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-enable pdo_mysql mysqli \
    && rm -rf /var/lib/apt/lists/*

# COMPOSER INSTALATION

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

COPY ./src /var/www/html/

RUN chmod -R 777 /var/www/html

WORKDIR /var/www/html

COPY ./php84/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm", "--nodaemonize"]