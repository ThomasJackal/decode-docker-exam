FROM alpine:3.19

RUN apk add --no-cache \
    postgresql16 \
    postgresql16-client \
    su-exec

COPY docker/postgres/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
