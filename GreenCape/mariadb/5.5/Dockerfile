FROM greencape/base
MAINTAINER Niels Braczek <nbraczek@bsds.de>

# Add our user and group first to make sure their IDs get assigned consistently, regardless of whatever dependencies get added
RUN groupadd -r mysql \
 && useradd -r -g mysql mysql

RUN apt-key adv --keyserver ha.pool.sks-keyservers.net --recv-keys 199369E5404BD5FC7D2FE43BCBCB082A1BB943DB

ENV MARIADB_MAJOR 5.5
ENV MARIADB_VERSION 5.5.44+maria-1~trusty

RUN echo "deb http://ftp.osuosl.org/pub/mariadb/repo/$MARIADB_MAJOR/ubuntu trusty main" > /etc/apt/sources.list.d/mariadb.list \
 && { \
        echo 'Package: *'; \
        echo 'Pin: release o=MariaDB'; \
        echo 'Pin-Priority: 999'; \
    } > /etc/apt/preferences.d/mariadb

RUN apt-get update \
 && apt-get install -y mariadb-server=$MARIADB_VERSION \
 && rm -rf /var/lib/mysql \
 && mkdir /var/lib/mysql \
 && sed -ri 's/^(bind-address|skip-networking)/;\1/' /etc/mysql/my.cnf

VOLUME /var/lib/mysql

RUN mkdir -p /etc/my_init.d
ADD init.sh /etc/my_init.d/01_mysql.sh

RUN mkdir /etc/service/mysql
ADD run.sh /etc/service/mysql/run

# Clean up APT when done.
RUN apt-get clean
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 3306
# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]
