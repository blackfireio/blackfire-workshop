FROM tucksaun/blackfire-workshop:base
MAINTAINER Tugdual Saunier <tugdual.saunier@blackfire.io>

RUN apt-get update && \
    apt-get install -y git graphviz && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN git clone https://github.com/FriendsOfPHP/uprofiler && \
    cd uprofiler/extension && \
    phpize && ./configure && make install && \
    echo "extension=uprofiler.so\nuprofiler.output_dir=/app/outputs/xhprof\nauto_prepend_file=/app/app/bootstrap_xhprof.php" > $PHP_INI_DIR/conf.d/uprofiler.ini && \
    cd / && rm -Rf /uprofiler
