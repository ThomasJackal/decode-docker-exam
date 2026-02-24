FROM php:8.2-alpine

RUN apk add --no-cache \
    postgresql-dev \
    libxml2-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) pdo_pgsql pgsql mbstring xml zip intl opcache

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
