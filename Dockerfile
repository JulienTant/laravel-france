FROM php:7.4-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache git zip
RUN docker-php-ext-install pdo_mysql bcmath
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'c5b9b6d368201a9db6f74e2611495f369991b72d9c8cbd3ffbc63edff210eb73d46ffbfce88669ad33695ef77dc76976') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN mkdir /var/www/storage && chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

RUN mkdir /.composer && chmod -R 777 /.composer
ENV COMPOSER_HOME /.composer
