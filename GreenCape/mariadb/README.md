# Supported tags and respective `Dockerfile` links

-	[`10.1.6`, `10.1`, `10`, `latest` (*10.1/Dockerfile*)](https://github.com/GreenCape/docker/blob/fbae87dd7b15dfc3915c0034e987f274263ab61f/GreenCape/mariadb/10.1/Dockerfile)
	[![ImageLayers.io](https://badge.imagelayers.io/greencape/mariadb:10.1.svg)](https://imagelayers.io/?images=greencape/mariadb:10.1)
-	[`10.0.20`, `10.0` (*10.0/Dockerfile*)](https://github.com/GreenCape/docker/blob/fbae87dd7b15dfc3915c0034e987f274263ab61f/GreenCape/mariadb/10.0/Dockerfile)
	[![ImageLayers.io](https://badge.imagelayers.io/greencape/mariadb:10.0.svg)](https://imagelayers.io/?images=greencape/mariadb:10.0)
-	[`5.5.44`, `5.5`, `5` (*5.5/Dockerfile*)](https://github.com/GreenCape/docker/blob/fbae87dd7b15dfc3915c0034e987f274263ab61f/GreenCape/mariadb/5.5/Dockerfile)
	[![ImageLayers.io](https://badge.imagelayers.io/greencape/mariadb:5.5.svg)](https://imagelayers.io/?images=greencape/mariadb:5.5)

# What is MariaDB?

MariaDB is a community-developed fork of the MySQL relational database management system intended to remain free under the GNU GPL.
Being a fork of a leading open source software system, it is notable for being led by the original developers of MySQL,
who forked it due to concerns over its acquisition by Oracle.
Contributors are required to share their copyright with the MariaDB Foundation.

The intent is also to maintain high compatibility with MySQL,
ensuring a "drop-in" replacement capability with library binary equivalency and exact matching with MySQL APIs and commands.
It includes the XtraDB storage engine for replacing InnoDB, as well as a new storage engine,
Aria, that intends to be both a transactional and non-transactional engine perhaps even included in future versions of MySQL.

> [wikipedia.org/wiki/MariaDB](https://en.wikipedia.org/wiki/MariaDB)

![logo](https://raw.githubusercontent.com/docker-library/docs/master/mariadb/logo.png)

# How to use this image

## Start a `greencape/mariadb` server instance

	docker run --name some-mariadb -e MYSQL_ROOT_PASSWORD=mysecretpassword -d greencape/mariadb

This image includes `EXPOSE 3306` (the standard MySQL port),
so container linking will make it automatically available to the linked containers (as the following examples illustrate).

## Connect to it from an application

Since MariaDB is intended as a drop-in replacement for MySQL, it can be used with many applications.

	docker run --name some-app --link some-mariadb:mysql -d application-that-uses-mysql

## ... or via `mysql`

	docker run -it --link some-mariadb:mysql --rm greencape/mariadb sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD"'

## Environment Variables

The `greencape/mariadb` image uses several environment variables which are easy to miss.
While not all the variables are required, they may significantly aid you in using the image.

The variable names are prefixed with `MYSQL_` since the binary is `mysqld`,
and since the intention is to be a drop-in replacement for MySQL, as mentioned above.

### `MYSQL_ROOT_PASSWORD`

This is the one environment variable that is required.
This environment variable should be what you want to set the password for the `root` user to be.
In the above example, it is being set to "`mysecretpassword`".

### `MYSQL_USER`, `MYSQL_PASSWORD`

These optional environment variables are used in conjunction to both create a new user and set that user's password,
which will subsequently be granted all permissions for the database specified by the optional `MYSQL_DATABASE` variable.
Note that if you only have one of these two environment variables, then neither will do anything --
these two are required to be used in conjunction with one another.

Additionally, there is no need to specify `MYSQL_USER` with `root`, as the `root` user already exists by default,
and the password of that user is controlled by `MYSQL_ROOT_PASSWORD` (see above).

### `MYSQL_DATABASE`

This optional environment variable denotes the name of a database to create.
If a user/password was supplied (via the `MYSQL_USER` and `MYSQL_PASSWORD` environment variables),
then that user will be granted (via `GRANT ALL`) access to this database.

# Caveats

If there is no database initialized when the container starts, then a default database will be created.
While this is the expected behavior, this means that it will not accept incoming connections until such initialization completes.
This may cause issues when using automation tools, such as `docker-compose`, which start several containers simultaneously.

# Supported Docker versions

This image is officially supported on Docker version 1.7.1.

Support for older versions (down to 1.0) is provided on a best-effort basis.

# MIT License

Copyright (c) 2015 BSDS Braczek Software- und DatenSysteme

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

# User Feedback

## Documentation

@todo

## Issues

If you have any problems with or questions about this image, please contact us through a [GitHub issue](https://github.com/GreenCape/docker/issues).

## Contributing

You are invited to contribute new features, fixes, or updates, large or small;
we are always thrilled to receive pull requests, and do our best to process them as fast as we can.

Before you start to code, we recommend discussing your plans through a [GitHub issue](https://github.com/GreenCape/docker/issues),
especially for more ambitious contributions.
This gives other contributors a chance to point you in the right direction,
give you feedback on your design, and help you find out if someone else is working on the same thing.
