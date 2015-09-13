FROM tucksaun/blackfire-workshop:base
MAINTAINER Tugdual Saunier <tugdual.saunier@blackfire.io>

RUN pecl install xdebug
RUN rm -Rf /tmp/pear
RUN echo "zend_extension=xdebug.so\nxdebug.profiler_enable=1\nxdebug.profiler_output_dir=/app/outputs/xdebug\nxdebug.profiler_output_name=callgrind.%u" > $PHP_INI_DIR/conf.d/xdebug.ini
