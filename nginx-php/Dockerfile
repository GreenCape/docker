FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ADD nginx.repo /etc/yum.repos.d/

RUN yum -y install \
    yum-plugin-replace

ENV PHP_VERSION php56u

RUN yum -y install \
    nginx \
    $PHP_VERSION \
    $PHP_VERSION-common \
    $PHP_VERSION-fpm \
    $PHP_VERSION-process \
    $PHP_VERSION-pecl-jsonc \
    $PHP_VERSION-cli \
    $PHP_VERSION-mysqlnd \
    $PHP_VERSION-pdo \
    $PHP_VERSION-devel \
    $PHP_VERSION-gd \
    $PHP_VERSION-pspell \
    $PHP_VERSION-snmp \
    $PHP_VERSION-xmlrpc \
    $PHP_VERSION-xml \
    $PHP_VERSION-pear \
    $PHP_VERSION-mcrypt \
    $PHP_VERSION-mbstring \
    $PHP_VERSION-opcache \
    python-setuptools \
    postfix \
    gcc \
    make \
 && yum clean all

RUN pecl install channel://pecl.php.net/xhprof-0.9.4 \
 && pecl install xdebug

RUN echo "extension=xhprof.so" >> /etc/php.d/xhprof.ini \
 && echo "zend_extension=/usr/lib64/php/modules/xdebug.so" >> /etc/php.d/xdebug.ini

RUN easy_install pip \
 && pip install "pip>=1.4,<1.5" --upgrade \
 && pip install supervisor

RUN useradd webserver -u 666 \
 && gpasswd -a webserver apache \
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
