FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ADD nginx.repo /etc/yum.repos.d/

RUN yum -y install nginx \
 && yum clean all

ADD default.conf /etc/nginx/conf.d/default.conf

RUN sed -i '/worker_processes  1;/a daemon off;' /etc/nginx/nginx.conf

ADD run /usr/local/bin/

RUN chmod +x /usr/local/bin/run

CMD ["/usr/local/bin/run"]
