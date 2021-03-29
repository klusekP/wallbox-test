FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add composer --no-cache \
    && apk add nginx --no-cache \
    # fix issue running /run/nginx/nginx.pid
    && mkdir /run/nginx \
    && chown -R nginx:nginx /run/nginx \
    # forward request and error logs to docker log collector
    && ln -sf /dev/stdout /var/log/nginx/project_access.log \
    && ln -sf /dev/stderr /var/log/nginx/project_error.log

COPY ./docker/bin/run.sh /opt/bin/run.sh
RUN chown nginx:nginx /opt/bin/run.sh
RUN chmod +x /opt/bin/run.sh
COPY ./docker/config/default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/html
RUN composer install
CMD ["/opt/bin/run.sh"]
