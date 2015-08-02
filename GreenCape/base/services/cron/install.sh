#!/bin/bash
set -e
source /build.d/buildconfig
set -x

$minimal_apt_get_install cron
mkdir /etc/service/cron
chmod 600 /etc/crontab
cp -a /build.d/services/cron/service/* /etc/service/cron/

## Remove useless cron entries.
# Checks for lost+found and scans for mtab.
rm -f /etc/cron.daily/standard
rm -f /etc/cron.daily/upstart
rm -f /etc/cron.daily/dpkg
rm -f /etc/cron.daily/password
rm -f /etc/cron.weekly/fstrim
