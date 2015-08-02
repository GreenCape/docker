#!/bin/bash
echo -n "Waiting for MySQL to start "
until pids=$(pidof mysqld)
do
    echo -n "."
    sleep 0.1
done
echo "ok"
exec sv status mysqld
