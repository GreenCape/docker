FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN yum -y install mariadb php php-fpm php-mysql php-pdo php-devel php-gd php-pecl-memcache php-pspell php-snmp php-xmlrpc php-xml php-mcrypt && yum clean all
ADD run /usr/local/bin/
RUN chmod +x /usr/local/bin/run
CMD ["/usr/local/bin/run"]
