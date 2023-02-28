FROM php:7.4-apache

RUN apt-get update
RUN apt-get install -y apache2-utils
RUN a2enmod rewrite
RUN apt-get install -y libpq-dev 

# Install php extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pgsql pdo pdo_mysql pdo_pgsql pgsql mysqli && docker-php-ext-enable mysqli pgsql pdo pdo_mysql pdo_pgsql 
RUN pecl install redis xdebug-3.1.6 && docker-php-ext-enable redis xdebug

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./conf/php-conf.ini $PHP_INI_DIR/conf.d/

ENV APACHE_DOCUMENT_ROOT /home/public_html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# vinhjaxt
RUN sed -i -E 's/Listen\s+80([^0-9]|$)/Listen 8001\1/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf /etc/apache2/sites-enabled/*.conf

RUN sed -i -E 's/(VirtualHost\s+.+)\:80([^0-9]|$)/\1:8001\2/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf /etc/apache2/sites-enabled/*.conf


