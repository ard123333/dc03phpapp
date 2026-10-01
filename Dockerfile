FROM php:7.2-apache
RUN docker-php-ext-install mysqli
COPY src/index.php src/dbinfo.inc /var/www/html/