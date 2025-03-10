FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libmariadb-dev curl bash \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/

CMD ["php-fpm"]
