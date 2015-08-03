#!/bin/bash
set -e
source /build.d/buildconfig
set -x

## Install init process.
cp -a /build.d/bin/my_init /sbin/
mkdir -p /etc/my_init.d
mkdir -p /etc/container_environment
touch /etc/container_environment.sh
touch /etc/container_environment.json
chmod 700 /etc/container_environment

groupadd -g 8377 docker_env
chown :docker_env /etc/container_environment.sh /etc/container_environment.json
chmod 640 /etc/container_environment.sh /etc/container_environment.json
ln -s /etc/container_environment.sh /etc/profile.d/

## Install runit.
$minimal_apt_get_install runit

## Install a syslog daemon and logrotate.
[ "$DISABLE_SYSLOG" -eq 0 ] && /build.d/services/syslog-ng/install.sh || true
[ "$DISABLE_SYSLOG" -eq 0 ] && /build.d/services/syslog-forwarder/install.sh || true

## Install the SSH server.
[ "$DISABLE_SSH" -eq 0 ] && /build.d/services/sshd/install.sh || true

## Install cron daemon.
[ "$DISABLE_CRON" -eq 0 ] && /build.d/services/cron/install.sh || true
