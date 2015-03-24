FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ADD nginx.repo /etc/yum.repos.d/
ADD hhvm.repo /etc/yum.repos.d/
RUN yum -y install yum-plugin-replace
RUN yum -y install nginx mariadb hhvm python-setuptools postfix gcc make && yum clean all
RUN easy_install pip && pip install "pip>=1.4,<1.5" --upgrade && pip install supervisor
RUN groupadd apache && useradd webserver -u 666 && gpasswd -a webserver apache && mkdir -p /var/www/html/ && chown -R webserver:webserver /var/www/html/
ADD index.php /var/www/html/
ADD supervisord.conf /etc/supervisord.conf
ADD nginx.conf /etc/nginx/nginx.conf
ADD default.conf /etc/nginx/conf.d/default.conf
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
ADD run /usr/local/bin/
RUN chmod +x /usr/local/bin/run
RUN yum -y remove gcc cpp glibc-devel glibc-headers  kernel-headers libmpc mpfr
CMD ["/usr/local/bin/run"]
