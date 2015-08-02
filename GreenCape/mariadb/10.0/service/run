#!/bin/bash
set -e

# Read DATADIR from the MySQL config
DATADIR="$(mysqld --verbose --help 2>/dev/null | awk '$1 == "datadir" { print $2; exit }')"
DATADIR=${DATADIR:-"/var/lib/mysql"}

set -- /usr/sbin/mysqlmysqld --datadir="$DATADIR"

if [ ! -d "$DATADIR/mysql" ]; then
    echo 'Running mysql_install_db ...'
    mysql_install_db --datadir="$DATADIR"
    echo 'Finished mysql_install_db'

    # These statements _must_ be on individual lines, and _must_ end with
    # semicolons (no line breaks or comments are permitted).
    tempSqlFile='/tmp/mysql-first-time.sql'
    cat > "$tempSqlFile" <<-EOSQL
		DELETE FROM mysql.user ;
		CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}' ;
		GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION ;
		DROP DATABASE IF EXISTS test ;
	EOSQL

    if [ "$MYSQL_DATABASE" ]; then
        echo "CREATE DATABASE IF NOT EXISTS \`$MYSQL_DATABASE\` ;" >> "$tempSqlFile"
    fi

    if [ "$MYSQL_USER" -a "$MYSQL_PASSWORD" ]; then
        echo "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD' ;" >> "$tempSqlFile"

        if [ "$MYSQL_DATABASE" ]; then
            echo "GRANT ALL ON \`$MYSQL_DATABASE\`.* TO '$MYSQL_USER'@'%' ;" >> "$tempSqlFile"
        fi
    fi

    echo 'FLUSH PRIVILEGES ;' >> "$tempSqlFile"

    set -- mysqld --datadir="$DATADIR" --init-file="$tempSqlFile"

    chown -R mysql:mysql "$DATADIR"
fi

exec /sbin/setuser mysql "$@"
