#!/bin/bash
set -e
source /build.d/buildconfig
set -x

## Often used tools.
$minimal_apt_get_install curl less nano psmisc

## This tool runs a command as another user and sets $HOME.
mv /build.d/bin/setuser /sbin/setuser
