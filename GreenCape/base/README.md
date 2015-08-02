# Supported tags and respective `Dockerfile` links

-	[`latest` (*Dockerfile*)](https://github.com/GreenCape/docker/blob/master/base/Dockerfile)

# What is Base?

This base image is a special Docker image that is configured for correct use within Docker containers,
heavily inspired by [`phusion/baseimage`](https://registry.hub.docker.com/u/phusion/baseimage/).

As `phusion/baseimage`, this is Ubuntu, plus:

 * Modifications for Docker-friendliness.
 * Mechanisms for easily running multiple processes, without violating the Docker philosophy.
 * Simplified service management.

## What is the difference?

The management scripts for the services are collected in separate directories (`<service-name>/service`),
which structure matches the expectations of `runit`.
This allows to easily add other control scripts like `finish` and `check` to the existing `run` without modification
of the installation scripts.
It is possible to add a `control` subdirectory to add the management hooks described in the
[`runit` documentation](http://smarden.org/runit/runsv.8.html).

This base image still provides `nano` as the preferred editor, which was replaced with `vim.tiny` in `phusion/baseimage`.

For the use of the base image, the documentation on the [Phusion Baseimage website](http://phusion.github.io/baseimage-docker/)
still applies.

# How to use this image

The intention of this image is to provide an optimized base for other images.

```
FROM greencape/base:latest

# ... put your own build instructions here ...

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Start the init system.
CMD ["/sbin/my_init"]
```

To look around in the image, run:

```
docker run -it --rm greencape/base /sbin/my_init -- bash -l
```

# Supported Docker versions

This image is officially supported on Docker version 1.7.0.

Support for older versions (down to 1.0) is provided on a best-effort basis.

# User Feedback

## Documentation

See the great documentation in the [Phusion Baseimage repository](https://github.com/phusion/baseimage-docker).  

## Issues

If you have any problems with or questions about this image,
please contact us through a [GitHub issue](https://github.com/GreenCape/docker/issues).

## Contributing

You are invited to contribute new features, fixes, or updates, large or small;
we are always thrilled to receive pull requests, and do our best to process them as fast as we can.

Before you start to code, we recommend discussing your plans through a [GitHub issue](https://github.com/GreenCape/docker/issues),
especially for more ambitious contributions.
This gives other contributors a chance to point you in the right direction, give you feedback on your design,
and help you find out if someone else is working on the same thing.
