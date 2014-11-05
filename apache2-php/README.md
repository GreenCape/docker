docker-apache2-dvhost-php5
==========================

OS: debian:latest

Software: apache2, php5

Setup: apache2 is configured for dynamic mass virtual hosts. Simply create a directory in /var/www equal to the name of your website (/var/www/exampledomain.com/web) No more tedious replication in /etc/apache2/sites-enabled

To use this image:

docker pull curtisbaldwinson/docker-apache2-dvhost-php5

docker run -p 80:80 -v /var/www:/var/www -d curtisbaldwinson/docker-apache2-dvhost-php5
