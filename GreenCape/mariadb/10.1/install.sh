#!/usr/bin/env bash
set -e
source /build.d/buildconfig
set -x

MYSQLD_BUILD_PATH=/build.d

# Add our user and group first to make sure their IDs get assigned consistently,
# regardless of whatever dependencies get added
groupadd -r mysql
useradd -r -g mysql mysql

apt-key adv --keyserver ha.pool.sks-keyservers.net --recv-keys 199369E5404BD5FC7D2FE43BCBCB082A1BB943DB

echo "deb http://ftp.osuosl.org/pub/mariadb/repo/$MARIADB_MAJOR/ubuntu trusty main" > /etc/apt/sources.list.d/mariadb.list
echo > /etc/apt/preferences.d/mariadb <<-pref
Package: *
Pin: release o=MariaDB
Pin-Priority: 999
pref

apt-get update

# Install MariaDB
$minimal_apt_get_install mariadb-server=$MARIADB_VERSION

mkdir -p /var/lib/mysql
sed -ri 's/^(bind-address|skip-networking)/;\1/' /etc/mysql/my.cnf

# Link service to runit
mkdir /etc/service/mysqld
mv $MYSQLD_BUILD_PATH/service/* /etc/service/mysqld/

# Add utilities
mv $MYSQLD_BUILD_PATH/wait.sh /sbin/wait-for-mysqld

# Clean up APT when done.
apt-get clean
rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
