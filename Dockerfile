FROM php:7.4.2-fpm
RUN apt-get update && \
      apt-get install -y autoconf pkg-config \
                curl \
                git \
                nano \
                libonig-dev \
                libsodium-dev \
                zip \
                unzip
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install sodium && docker-php-ext-enable sodium
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-install mbstring && docker-php-ext-enable mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www

#COPY / .
#RUN composer install
#RUN composer dump-autoload

CMD ["php-fpm"]
