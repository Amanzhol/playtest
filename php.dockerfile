FROM php:8.2-fpm-alpine

ENV PHPUSER=laravel
ENV PHPGROUP=laravel

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.conf

RUN mkdir -p /var/www/html/public

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer \
    pdo \
    pdo_mysql \
    bcmath \
    zip

CMD ["php-fpm","-y","/usr/local/etc/php-fpm.conf","-R"]

