FROM php:7.2-apache

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APACHE_DOCUMENT_ROOT /app
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

EXPOSE 80
EXPOSE 443

RUN apt-get update -qy && \
    apt-get install -y \
    git \
    libicu-dev \
    unzip \
    vim \
    libzip-dev \
    libpng-dev \
    zip \
    certbot \
    python-certbot-apache && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    /usr/local/bin/composer --version

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure opcache --enable-opcache
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql mbstring zip gd intl
RUN pecl install apcu-5.1.2 && docker-php-ext-enable apcu

ADD conf/php.ini /usr/local/etc/php/conf.d/app.ini

ADD conf/vhost.conf /etc/apache2/sites-available/000-default.conf
ADD conf/apache.conf /etc/apache2/conf-available/z-app.conf

RUN mkdir /etc/apache2/ssl
ADD conf/gse.crt /etc/apache2/ssl/ssl.crt
ADD conf/gse.key /etc/apache2/ssl/ssl.key

RUN a2enmod rewrite remoteip ssl
RUN a2enconf z-app

