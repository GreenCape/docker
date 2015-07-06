# Docker Base

This base image is just a wrapper for [phusion/baseimage](https://registry.hub.docker.com/u/phusion/baseimage/).

phusion/baseimage is a special Docker image that is configured for correct use within Docker containers. It is Ubuntu, plus:

 * Modifications for Docker-friendliness.
 * Administration tools that are especially useful in the context of Docker.
 * Mechanisms for easily running multiple processes, without violating the Docker philosophy.

Read the full story at the [Phusion Baseimage website](http://phusion.github.io/baseimage-docker/).

## Why a Wrapper?

The wrapper gives the possibility to generally add services to the GreenCape images in a central place.
Currently, no such services are needed, so phusion/baseimage is used without modifications.
  
## Documentation
  
See the great documentation in the [Phusion Baseimage repository](https://github.com/phusion/baseimage-docker).  
