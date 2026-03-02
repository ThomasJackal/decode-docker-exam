FROM alpine:3.19

RUN apk add --no-cache \
    php82 \
    php82-phar \
    php82-mbstring \
    php82-openssl \
    php82-zip \
    php82-tokenizer \
    php82-xml \
    php82-dom \
    php82-simplexml \
    php82-fileinfo \
    git \
    unzip \
    curl \
    && ln -sf /usr/bin/php82 /usr/bin/php \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

ENTRYPOINT ["composer"]