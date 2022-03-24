FROM phpdockerio/php:8.1-fpm
WORKDIR "/application"

RUN apt update -y; \
    apt install -y mysql-server; \
    apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        curl \
        php8.1-gd \
        php8.1-grpc \
        php8.1-http \
        php8.1-imagick \
        php8.1-ldap \
        php8.1-mcrypt \
        php8.1-soap \
        php8.1-xsl \
        php8.1-raphf \
        php-mysql; \
    apt-get clean; \
    service mysql restart; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN chown -R www-data:www-data /application
