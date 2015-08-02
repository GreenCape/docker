#!/bin/bash
set -e
source /bd_build/buildconfig
set -x

SYSLOG_NG_BUILD_PATH=/bd_build/services/syslog-forwarger

## Install syslog to "docker logs" forwarder.
mkdir /etc/service/syslog-forwarder
cp $SYSLOG_NG_BUILD_PATH/syslog-forwarder.runit /etc/service/syslog-forwarder/run
