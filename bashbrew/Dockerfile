FROM debian:wheezy
MAINTAINER Niels Braczek <nbraczek@bsds.de>

RUN apt-get update \
 && apt-get install -y \
    git \
 && apt-get clean

RUN git clone https://github.com/docker-library/official-images.git \
 && mv /official-images/bashbrew/bashbrew.sh /usr/bin/bashbrew \
 && mv /official-images/bashbrew/travis.sh /usr/bin/travis \
 && mv /official-images/bashbrew/git-set-mtimes /usr/bin/git-set-mtimes \
 && rm -rf /official-images

VOLUME /src

WORKDIR /src
ENTRYPOINT ["bash"]

