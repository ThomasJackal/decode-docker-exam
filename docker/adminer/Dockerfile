FROM alpine:3.19

RUN apk add --no-cache php php-session php-pdo php-pdo_pgsql php-json wget \
    && mkdir -p /app \
    && wget -q -O /app/adminer.php https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php

WORKDIR /app
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080"]