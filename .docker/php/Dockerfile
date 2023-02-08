FROM php:8.2-fpm-alpine3.17

COPY --from=composer:2.4.4 /usr/bin/composer /usr/bin/composer

RUN set -ex && apk update && apk upgrade \
    # Clean-up
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear \
    && rm -rf /tmp/* /var/lib/apt/lists/* \
    && rm -rf /var/cache/apk/*

WORKDIR /app

CMD ["php-fpm"]
