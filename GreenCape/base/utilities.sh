#!/bin/bash
set -e
source /build.d/buildconfig
set -x

## Often used tools.
$minimal_apt_get_install curl less nano psmisc

## This tool runs a command as another user and sets $HOME.
cp -a /build.d/bin/setuser /sbin/setuser

## This tool waits for services
cp -a /build.d/wait.sh /sbin/wait-for
