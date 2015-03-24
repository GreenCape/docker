# MariaDB

A Docker build which runs just [MariaDB 5.5](https://mariadb.org/).

## Environment Variables

  - `MYSQL_ROOT_PASSWORD`: Password for the root user
  - `MYSQL_DATABASE`: Name of the database to create
  - `MYSQL_USER`: Database user 
  - `MYSQL_PASSWORD`: Password for the user `$MYSQL_USER`

## Examples

    docker run -d -p 3306:3306 greencape/mariadb
    docker run -d -p 3306:3306 -e MYSQL_ROOT_PASSWORD=y0Urp455w0rd greencape/mariadb
    docker run -d -p 3306:3306 -e MYSQL_ROOT_PASSWORD=y0Urp455w0rd -e MYSQL_DATABASE=my_base -e MYSQL_USER=rah -e MYSQL_PASSWORD=y0UrDbP455w0rD greencape/mariadb
    docker run -d -p 3306:3306 -e MYSQL_DATABASE=my_base greencape/mariadb
    docker run -d -p 3306:3306 --name="database" -e MYSQL_DATABASE=my_base -v /home/containers/database:/var/lib/mysql greencape/mariadb

## Password

If you didn't set `MYSQL_ROOT_PASSWORD` then you can run `docker logs` to see what password has been set;

    [root@docker ~]# docker run -d -p 3306:3306 greencape/mariadb
    26b504347376828eae8accda2715125a71e717c8462a8dbeba93189cb3bafdfa
    [root@docker mariadb]# docker ps
    CONTAINER ID        IMAGE                                COMMAND              CREATED             STATUS              PORTS                    NAMES
    26b504347376        greencape/mariadb:latest        /usr/local/bin/run   4 seconds ago       Up 3 seconds        0.0.0.0:3306->3306/tcp   mydbserver     
    [root@docker ~]# docker logs 26b504347376
    Installing MariaDB
    Starting MariaDB Server
    Setting a random password for user 'root'
    Stopping MariaDB Server
    Done.
    
    ========================================================================
    You can now connect to this MariaDB Server using:
    
        mysql -uroot -pc735bacb -h<host> -P<port> --protocol=TCP
    
    ========================================================================
    
    Starting MariaDB Server using its startup script
    [root@docker ~]# mysql -uroot -pc735bacb --protocol=TCP
    Welcome to the MariaDB monitor.  Commands end with ; or \g.
    Your MariaDB connection id is 2
    Server version: 5.5.37-MariaDB MariaDB Server
    
    Copyright (c) 2000, 2014, Oracle, Monty Program Ab and others.
    
    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
    
    MariaDB [(none)]> show databases;
    +--------------------+
    | Database           |
    +--------------------+
    | information_schema |
    | mysql              |
    | performance_schema |
    | test               |
    +--------------------+
    4 rows in set (0.01 sec)
    
    MariaDB [(none)]> exit
    Bye
