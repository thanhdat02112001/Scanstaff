FROM php:7.4-fpm-alpine

# Set Workdir
WORKDIR /app

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install Additional dependencies
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    bcmath \
    redis \
    pdo_mysql \
    zip

RUN apk --no-cache add autoconf g++ make && pecl install xdebug && docker-php-ext-enable xdebug && rm -rf /tmp/pear \
    apk del autoconf g++ make

RUN apk update && apk add \
        shadow \
        nodejs \
        yarn \
        bash

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

RUN chown -R www-data:www-data .

# Run PHP-FPM
CMD ["php-fpm"]

EXPOSE 9000
