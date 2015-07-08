# Nginx for PHP-FPM

A Docker build which runs a CentOS 7 container with Nginx, connecting to a PHP-FPM service.

## Configuration

### Nginx

The most current version of Nginx from the Nginx repository is used.

## Environment Variables

**`PHP_FPM_HOST`**

The name of the linked container for PHP-FPM, the default is `php-fpm`

**`PHP_FPM_PORT`**

The port number to connect to PHP-FPM, the default is `9000`

## Example

    $ sudo docker run -d -p 80:80 -v /home/containers/web:/var/www/html --link php:php-fpm greencape/nginx
