#!/bin/bash
set -e

WAITFOR_TIMEOUT=${WAITFOR_TIMEOUT:-5}

usage() {
    echo "Usage: "`basename $0`" service [...]"
}

if [ ${#@} -eq 0 ]; then
    usage
    exit 1
fi

for service in "$@"; do
    echo -n "Waiting for $service "
    START_TIME=$(date +%s)
    WAITFOR_STATUS="ok"
    until pids=$(pidof "$service")
    do
        echo -n "."
        sleep 1
        if [[ $(( $(date +%s) - $START_TIME )) > $WAITFOR_TIMEOUT ]]; then
            WAITFOR_STATUS="timeout (waited $WAITFOR_TIMEOUT seconds)"
            break
        fi
    done
    echo " "$WAITFOR_STATUS
    sv status "$service"
done
