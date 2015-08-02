#!/bin/bash
set -e
source /build.d/buildconfig
set -x

SYSLOG_NG_BUILD_PATH=/build.d/services/syslog-forwarger

## Install syslog to "docker logs" forwarder.
mkdir /etc/service/syslog-forwarder
cp -a $SYSLOG_NG_BUILD_PATH/service/* /etc/service/syslog-forwarder/
