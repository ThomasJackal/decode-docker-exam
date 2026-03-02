FROM alpine:3.19

RUN apk add --no-cache \
    php82 \
    php82-ctype \
    php82-pdo_pgsql \
    php82-pgsql \
    php82-mbstring \
    php82-xml \
    php82-dom \
    php82-zip \
    php82-intl \
    php82-opcache \
    php82-session \
    php82-tokenizer \
    postgresql-libs \
    && ln -sf /usr/bin/php82 /usr/bin/php

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
