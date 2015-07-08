#!/bin/bash
set -e

exec /sbin/setuser mysql /usr/sbin/mysqld --datadir='/var/lib/mysql/'
