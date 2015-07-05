FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ENV PHP_VERSION php56u

RUN yum -y install \
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
    $PHP_VERSION-dba \
    $PHP_VERSION-xdebug \
    python-setuptools \
    postfix \
    gcc \
    make \
  && yum clean all
ADD run /usr/local/bin/
RUN chmod +x /usr/local/bin/run
CMD ["/usr/local/bin/run"]
