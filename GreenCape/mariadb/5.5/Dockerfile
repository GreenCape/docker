FROM greencape/base:latest
MAINTAINER Niels Braczek <nbraczek@bsds.de>

ENV MARIADB_MAJOR 5.5
ENV MARIADB_VERSION 5.5.44+maria-1~trusty

ADD . /build.d

RUN /build.d/install.sh

VOLUME /var/lib/mysql

EXPOSE 3306

CMD ["/sbin/my_init"]
