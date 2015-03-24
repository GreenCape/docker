# Nginx & PHP

A Docker build which runs a CentOS 7 container with Nginx and PHP 5.4.

## Configuration

### Nginx

The most current version of Nginx from the Nginx repository is used.

The `default.conf` file for Nginx is
 
    server {
        listen       80 default_server;
        server_name  _;
    
        root   /var/www/html;
    
        access_log  /var/log/nginx/access.log  main;
        error_log  /var/log/nginx/error.log;
    
        location / {
            index  index.html index.htm index.php;
        }
    
        error_page  404              /404.html;
        location = /404.html {
            root   /usr/share/nginx/html;
        }
    
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   /usr/share/nginx/html;
        }
    
        location ~ \.php$ {
            fastcgi_pass   localhost:9000;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
    
        location ~ /\.ht {
            deny  all;
        }
    }

### PHP

The most current version of PHP from the Centos repository is used.

Installed packages include

  - `php-fpm`
  - `php-mysql`
  - `php-pdo`
  - `php-devel`
  - `php-gd`
  - `php-pecl-memcache`
  - `php-pspell`
  - `php-snmp`
  - `php-xmlrpc`
  - `php-xml`
  - `php-mcrypt`
  - `php-mbstring`
  - `php-imap`
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

If not empty, composer install will be run as the `webserver` user in `/var/www/html/`

**`VIRTUAL_HOST`**

The domain name for the container, e.g. `www.customer.dev`

## Examples

    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html greencape/nginx-php
    $ sudo docker run -d -p 80 -v /home/containers/web:/var/www/html -e VIRTUAL_HOST=www.customer.dev --link database:db greencape/nginx-php

## Notes

  1. If you want the contained webserver to listen at port 80, be sure not to have a local webserver running and listening at the same port.

  2. Nginx runs as a user called `webserver`. If you are mounting volumes please create a matching user on your host system using the following;

        $ sudo useradd webserver -u 666
