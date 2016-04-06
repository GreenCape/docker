FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN add-apt-repository -y ppa:nginx/stable
# RUN add-apt-repository -y ppa:ondrej/php

ENV TERM "dumb"

RUN apt-get -y update \
 && apt-get -y install --no-install-recommends --force-yes \
    nginx \
    php5 \
    php5-common \
    php5-fpm \
    php5-cli \
    php5-mysqlnd \
    php5-gd \
    php5-pspell \
    php5-snmp \
    php5-xmlrpc \
    php5-mcrypt \
    php5-dev \
    php5-json \
    php-pear \
    # php-pdo \
    # php-xml \
    # php-mbstring \
    # php-opcache \
    # php-process \
    python-setuptools \
    postfix \
    gcc \
    make \
 && apt-get autoremove \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install channel://pecl.php.net/xhprof-0.9.4 \
 && pecl install xdebug

#RUN echo "extension=xhprof.so" >> /etc/php5/cgi/conf.d/xhprof.ini \
# && echo "extension=xhprof.so" >> /etc/php5/cli/conf.d/xhprof.ini \
# && echo "zend_extension=/usr/lib64/php/modules/xdebug.so" >> /etc/php5/cgi/conf.d/xdebug.ini
# && echo "zend_extension=/usr/lib64/php/modules/xdebug.so" >> /etc/php5/cli/conf.d/xdebug.ini

RUN easy_install pip \
 && pip install "pip>=1.4,<1.5" --upgrade \
 && pip install supervisor

RUN useradd webserver -u 666 \
 && gpasswd -a webserver webserver \
 && mkdir -p /var/www/html/ \
 && chown -R webserver:webserver /var/www/html/

ADD index.php /var/www/html/
ADD supervisord.conf /etc/supervisord.conf
ADD nginx.conf /etc/nginx/nginx.conf
ADD default.conf /etc/nginx/conf.d/default.conf

RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

ADD run /usr/local/bin/

RUN chmod +x /usr/local/bin/run

RUN yum -y remove \
    gcc \
    cpp \
    glibc-devel \
    glibc-headers  \
    kernel-headers \
    libmpc \
    mpfr

CMD ["/usr/local/bin/run"]
