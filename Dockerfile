FROM php:8.2-cli

RUN docker-php-ext-install bcmath pdo_mysql

WORKDIR /var/www

COPY ./ .

CMD ["php", "./tree.php"]