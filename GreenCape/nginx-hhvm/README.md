# Nginx & PHP

A Docker build which runs a CentOS 7 container with Nginx and HHVM.

## Configuration

### Nginx

The most current version of Nginx from the Nginx repository is used.

### HHVM

The most current version of HHVM from the Fedora repository is used.

## Environment Variables

**`CUSTOM_CONF`**

If not empty, the `default.conf` file will be replaced by a symlink to `/var/www/html/.docker/nginx.conf`.

**`RUN_COMPOSER`**

If not empty, `composer install` will be run as the `webserver` user in `/var/www/html/`

**`VIRTUAL_HOST`**

The domain name for the container, e.g. `www.customer.dev`

**`MAIL_PORT_25_TCP_ADDR`**

Relay host for postfix

## Examples

    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html greencape/nginx-hhvm
    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html -e VIRTUAL_HOST=www.customer.dev --link database:db greencape/nginx-hhvm

## Notes

  1. If you want the contained webserver to listen at port 80, be sure not to have a local webserver running and listening at the same port.

  2. Nginx runs as a user called `webserver`. If you are mounting volumes please create a matching user on your host system using the following;

        $ sudo useradd webserver -u 666
