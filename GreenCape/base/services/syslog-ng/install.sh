#!/bin/bash
set -e
source /build.d/buildconfig
set -x

SYSLOG_NG_BUILD_PATH=/build.d/services/syslog-ng

## Install a syslog daemon.
$minimal_apt_get_install syslog-ng-core
mkdir /etc/service/syslog-ng
cp -a $SYSLOG_NG_BUILD_PATH/service/* /etc/service/syslog-ng/
mkdir -p /var/lib/syslog-ng
cp $SYSLOG_NG_BUILD_PATH/syslog_ng_default /etc/default/syslog-ng
touch /var/log/syslog
chmod u=rw,g=r,o= /var/log/syslog
cp $SYSLOG_NG_BUILD_PATH/syslog-ng.conf /etc/syslog-ng/syslog-ng.conf

## Install logrotate.
$minimal_apt_get_install logrotate
cp $SYSLOG_NG_BUILD_PATH/logrotate_syslogng /etc/logrotate.d/syslog-ng
