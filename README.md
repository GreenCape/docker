# Docker

A repo to house my trusted Docker builds, see my [Docker Index Profile](https://index.docker.io/u/greencape/) for more information.

These builds are built on the work of [Russ McKendrick](https://hub.docker.com/u/russmckendrick/), but will undergo a
series of changes and additions to make it more suitable for Joomla! development. 

To connect to these containers use `nsenter` / `docker-enter`, see [this blog post](https://media-glass.es/2014/08/25/connecting-to-docker-containers/) for details.

## General Containers

- [Base](https://registry.hub.docker.com/u/greencape/base/) - Base build for use with other Docker builds
- [Nginx Proxy](https://registry.hub.docker.com/u/greencape/nginx-proxy/) - A reverse proxy container

## CentOS 7 LEMP Stack

- [Nginx](https://registry.hub.docker.com/u/greencape/nginx/) - Nginx webserver for use with a [PHP-FPM container](https://registry.hub.docker.com/u/greencape/php-fpm/)
- [PHP 5.4 / PHP-FPM](https://registry.hub.docker.com/u/greencape/php-fpm/)- PHP 5.4 service using PHP-FPM for use with a [Nginx Container](https://registry.hub.docker.com/u/greencape/nginx/)
- [Nginx / PHP 5.4](https://registry.hub.docker.com/u/greencape/nginx-php/) - An all in-one Nginx / PHP container
- [Nginx / HHVM](https://registry.hub.docker.com/u/greencape/nginx-hhvm/) - An all in-one Nginx / HHVM container
- [MariaDB 10](https://registry.hub.docker.com/u/greencape/mariadb/) - A MariaDB 5.5 container, best used with other containers

To run a stack you would run something like;

``` bash
docker run -d -v /home/containers/database:/var/lib/mysql --name="database" greencape/mariadb
docker run -d -v /home/containers/web:/var/www/html --name="php" --link database:db greencape/php-fpm
docker run -d -p 80 -v /home/containers/web:/var/www/html -e VIRTUAL_HOST=some.domain.com --link php:php-fpm --name="nginx" greencape/nginx
```

Have a look at [this terminal session](https://asciinema.org/a/11731) for a demo or have a read of this [blog post](https://media-glass.es/2014/08/31/docker-fig-reverse-proxy-centos7/) for a more detailed overview.
