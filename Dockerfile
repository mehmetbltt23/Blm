FROM php:7.4.2-fpm
RUN apt-get update && \
      apt-get install -y autoconf pkg-config \
                curl
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
EXPOSE 9000
WORKDIR /var/www
COPY / .
CMD ["php-fpm"]
