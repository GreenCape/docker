FROM phusion/baseimage
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN apt-get update \
 && apt-get install -y \
    git \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -L https://github.com/docker-library/official-images/archive/master.tar.gz | tar -xpz \
 && mv /official-images-master /docker \
 && ln -s /docker/bashbrew/bashbrew.sh /usr/bin/bashbrew

VOLUME /docker/src

WORKDIR /docker/src
ENTRYPOINT ["bash"]

