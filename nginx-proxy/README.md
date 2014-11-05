# Nginx Proxy

A Docker build which runs a CentOS 7 container with Nginx and [docker-gen](https://github.com/jwilder/docker-gen)

##Example

```
docker run -d -p 80:80 -v /var/run/docker.sock:/tmp/docker.sock -t greencape/nginx-proxy
```

and then launch your container with the `VIRTUAL_HOST` environment variable;

```
docker run -p 80 -e VIRTUAL_HOST=some.domain.com -t ...
```

## Note

This is based on following by Jason Wilder:

  - [http://jasonwilder.com/blog/2014/03/25/automated-nginx-reverse-proxy-for-docker/](http://jasonwilder.com/blog/2014/03/25/automated-nginx-reverse-proxy-for-docker/)
  - [https://github.com/jwilder/nginx-proxy](https://github.com/jwilder/nginx-proxy)
