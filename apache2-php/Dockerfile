FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN yum -y install httpd mariadb php php-fpm php-mysql php-pdo php-devel php-gd php-pecl-memcache php-pspell php-snmp php-xmlrpc php-xml php-mcrypt php-mbstring php-imap php-pecl-xdebug php-pecl-xhprof python-setuptools && yum clean all
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
RUN easy_install pip && pip install "pip>=1.4,<1.5" --upgrade && pip install supervisor
RUN useradd www-data -u 666 && gpasswd -a www-data apache
ADD supervisord.conf /etc/supervisord.conf
ADD catchall /etc/apache2/sites-available/catchall
RUN a2enmod rewrite && a2dissite 000-default && a2enmod vhost_alias && a2ensite catchall
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
ADD run /usr/local/bin/
RUN chmod +x /usr/local/bin/run
CMD ["/usr/local/bin/run"]
