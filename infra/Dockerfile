FROM alpine:3.19

RUN apk update

RUN addgroup -S mygroup && adduser -S myuser -G mygroup

RUN mkdir -p /var/www/html \
    && chown -R myuser:mygroup /var/www/html \
    && chmod -R 777 /var/www/html

# install tool, nginx, php extension
RUN apk add --no-cache \
  git \
  curl \
  nginx \
  supervisor

RUN apk add --no-cache php83

RUN apk add --no-cache \
  php83-fpm \
  php83-cli \
  php83-ctype \
  php83-curl \
  php83-dom \
  php83-fileinfo \
  php83-gd \
  php83-intl \
  php83-mbstring \
  php83-mysqli \
  php83-opcache \
  php83-openssl \
  php83-phar \
  php83-session \
  php83-tokenizer \
  php83-xml \
  php83-xmlreader \
  php83-xmlwriter \
  php83-json \
  php83-pdo \
  php83-pdo_mysql \
  php83-sqlite3 \
  php83-zip \
  php83-xdebug \
  php83-pdo_sqlite \
  php83-bcmath \
  php83-redis \
  php83-simplexml \
  php83-iconv

# install composer
RUN php83 -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php83 composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php83 -r "unlink('composer-setup.php');" \
    && ln -s /usr/bin/php83 /usr/bin/php

# copy source app
COPY . /var/www/html
WORKDIR /var/www/html

RUN mkdir -p /run/nginx

# copy config for nginx, supervisord
COPY /infra/nginx.conf /etc/nginx/http.d/default.conf
COPY /infra/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R myuser:mygroup /var/www/html \
    && chmod -R 777 /var/www/html

# expose ports
EXPOSE 80

# start supervisord with file custom config
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]