#!/bin/bash
until pids=$(pidof mysqld)
do
        echo "....waiting for MySQL to start"
        sleep 1
done
