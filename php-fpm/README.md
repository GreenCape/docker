# PHP-FPM

A Docker build which runs a CentOS 7 container with PHP 5.6 using PHP-FPM.

## Environment Variables

**`PHP_POOL`**

The pool name to use (without brackets), the default is `[www]`

**`PHP_PORT`**

The port number to connect to PHP-FPM, the default is `9000`

**`PHP_USER`**

The user/group to run PHP as, the default is `webserver`

## Examples

    $sudo docker run -d -p 9000:9000 greencape/php-fpm
    $sudo docker run -d -p 9000:9000 -e PHP_POOL=testing --name="testing" greencape/php-fpm
    $sudo docker run -d -p 9000:9000 -e PHP_PORT=9001 -e PHP_USER=testing -e PHP_POOL=testing --name="testing" greencape/php-fpm
