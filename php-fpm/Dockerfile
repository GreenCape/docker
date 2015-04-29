FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/epel-release.rpm && rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm &&
yum -y install php54w php54w-fpm php54w-cli php54w-devel php54w-common php54w-dba php54w-gd php54w-mbstring php54w-mcrypt php54w-mysql php54w-pdo php54w-pspell php54w-snmp php54w-xdebug php54w-xml php54w-xmlrpc php54w-pecl-memcache &&
yum clean all
ADD run /usr/local/bin/
RUN chmod +x /usr/local/bin/run
CMD ["/usr/local/bin/run"]
