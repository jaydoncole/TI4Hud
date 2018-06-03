FROM php:7-fpm

RUN pecl install xdebug-2.6.0 && docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable xdebug
RUN echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so"' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_handler=dbgp' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_host=172.17.0.1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_autostart=on' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.var_display_max_data=-1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.var_display_max_children=-1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.var_display_max_depth=-1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.profiler_enable=1' >> /usr/local/etc/php/php.ini
