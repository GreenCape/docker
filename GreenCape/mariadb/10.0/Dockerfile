FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ENV MARIADB_MAJOR 10.0
ENV MARIADB_VERSION 10.0.20+maria-1~trusty

ADD . /build.d

RUN /build.d/install.sh

VOLUME /var/lib/mysql

EXPOSE 3306

CMD ["/sbin/my_init"]
