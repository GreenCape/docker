# Nginx & PHP

A Docker build which runs a Ubuntu 14.04 container with Nginx and PHP 5.5.9.

## Configuration

### Nginx

The most current version of Nginx from the Nginx repository is used.

### PHP

The most current version of PHP from the Ubuntu Trusty repository is used.

Installed packages include

  - `php5-common`
  - `php5-fpm`
  - `php5-cli`
  - `php5-mysqlnd`
  - `php5-gd`
  - `php5-pspell`
  - `php5-snmp`
  - `php5-xmlrpc`
  - `php5-mcrypt`
  - `php5-dev`
  - `php5-json`
  - `php-pear`
  - `php-pecl-xdebug`
  - `php-pecl-xhprof`

These settings are changed explicitly:

  - `memory_limit` is set to `768M`
  - `post_max_size` is set to `50M`
  - `date.timezone` is set to `Europe/London`

All other settings stay untouched with their default values.

## Environment Variables

**`CUSTOM_CONF`**

If not empty, the `default.conf` file will be replaced by a symlink to `/var/www/html/.docker/nginx.conf`.

**`PHP_POOL`**

The pool name to use (without brackets), the default is `[www]`

**`RUN_COMPOSER`**

If not empty, `composer install` will be run as the `webserver` user in `/var/www/html/`

**`VIRTUAL_HOST`**

The domain name for the container, e.g. `www.customer.dev`

**`MAIL_PORT_25_TCP_ADDR`**

Relay host for postfix

## Examples

    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html greencape/nginx-php
    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html -e VIRTUAL_HOST=www.customer.dev --link database:db greencape/nginx-php

## Notes

  1. If you want the contained webserver to listen at port 80, be sure not to have a local webserver running and listening at the same port.

  2. Nginx runs as a user called `webserver`. If you are mounting volumes please create a matching user on your host system using the following;

        $ sudo useradd webserver -u 666
