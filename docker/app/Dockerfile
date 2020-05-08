FROM php:7.2-fpm
MAINTAINER Tiago Gomes geone85@gmail.com
WORKDIR /code

# Install and enable XDebug
RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

# Install pdo mysql driver
RUN docker-php-ext-install pdo pdo_mysql bcmath mbstring

ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install APCu and APC backward compatibility
RUN pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

# mcrypt is deprecated in favor of openssl
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd mcrypt

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

# Install supervisor
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    supervisor

ADD config/supervisord.conf /etc/supervisor
ADD worker/* /etc/supervisor/conf.d

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]