# Nginx & PHP

A Docker build which runs a CentOS 7 container with Nginx and PHP 5.4.

## Environment Variables

  - `CUSTOM_CONF`: If `yes`, the default.conf file will be removed and a sym link to `/var/www/html/.docker/nginx.conf` created.
  - `RUN_COMPOSER`: If `yes`, composer install will be run as the `webserver` user in `/var/www/html/`
  - `PHP_POOL`: The Pool name to use, the default is `[www]`

## Examples

```
docker run -d -p 80 -v /home/containers/web:/var/www/html greencape/nginx-php
docker run -d -p 80 -v /home/containers/web:/var/www/html -e VIRTUAL_HOST=some.domain.com --link database:db greencape/nginx-php
```

## Notes

Nginx runs as a user called `webserver`. If you are mounting volumes please create a matching user on your host system using the following;

    $ sudo useradd webserver -u 666
