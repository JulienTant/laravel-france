FROM php:7.4-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache git zip
RUN docker-php-ext-install pdo_mysql bcmath
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN mkdir /var/www/storage && chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

RUN mkdir /.composer && chmod -R 777 /.composer
ENV COMPOSER_HOME /.composer

RUN mkdir /.config && chmod -R 777 /.config
