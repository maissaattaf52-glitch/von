FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    procps \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    supervisor \
    && docker-php-ext-install zip pdo_mysql mysqli bcmath

RUN pecl install swoole && docker-php-ext-enable swoole

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/servers

RUN mkdir -p /var/log/supervisor && \
    chown -R www-data:www-data /var/log/supervisor

EXPOSE 80
EXPOSE 7777
EXPOSE 9501

WORKDIR /var/www/html

CMD ["apache2-foreground"]