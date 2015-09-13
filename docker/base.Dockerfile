FROM php:5.6-cli
MAINTAINER Tugdual Saunier <tugdual.saunier@blackfire.io>

RUN /usr/local/bin/docker-php-ext-install mbstring
RUN /usr/local/bin/docker-php-ext-install opcache
RUN pecl install apcu-beta
RUN rm -Rf /tmp/pear

COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY start.sh /start.sh

ENV TERM xterm
ENV SYMFONY_ENV prod
ENV PORT 80
WORKDIR /app

EXPOSE ${PORT}

CMD ["/start.sh"]
