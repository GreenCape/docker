# Supported tags and respective `Dockerfile` links

-	[`latest` (*Dockerfile*)](https://github.com/GreenCape/docker/blob/master/jekyll/Dockerfile)

# What is Jekyll?

Jekyll is a simple, blog-aware, static site generator. It takes a template directory containing raw text files in various formats, runs it through a converter (like Markdown) and our Liquid renderer, and spits out a complete, ready-to-publish static website suitable for serving with your favorite web server. Jekyll also happens to be the engine behind GitHub Pages, which means you can use Jekyll to host your project’s page, blog, or website from GitHub’s servers for free.

> [jekyllrb.com/docs/home/](http://jekyllrb.com/docs/home/)

![logo](https://github.com/GreenCape/docker/blob/master/jekyll/docs/logo.png)

# How to use this image

This image provides Jekyll together with the github-pages extension, so it is suitable to preview content for
organisation pages or the `gh-pages` branch of your project.

```
$ cd path/to/your/project
$ docker run --rm -v "$PWD:/src" -p 4000:4000 greencape/jekyll serve
```

Now browse to http://localhost:4000 to see your rendered contents.

To make `jekyll` available as a command on your command line, add an alias into your `.bashrc`:

```
alias jekyll="docker run --rm -v "$PWD:/src" -p 4000:4000 greencape/jekyll"
```

# License

View [license information](https://github.com/jekyll/jekyll/blob/master/LICENSE) for the software contained in this image.

# Supported Docker versions

This image is officially supported on Docker version 1.7.0.

Support for older versions (down to 1.0) is provided on a best-effort basis.

# User Feedback

## Documentation

Documentation for this image is stored in the [`jekyll/` directory](https://github.com/GreenCape/docker/tree/master/jekyll) of the [`GreenCape/docker` GitHub repo](https://github.com/GreenCape/docker).

## Issues

If you have any problems with or questions about this image, please contact us through a [GitHub issue](https://github.com/GreenCape/docker/issues).

## Contributing

You are invited to contribute new features, fixes, or updates, large or small; we are always thrilled to receive pull requests, and do our best to process them as fast as we can.

Before you start to code, we recommend discussing your plans through a [GitHub issue](https://github.com/GreenCape/docker/issues), especially for more ambitious contributions. This gives other contributors a chance to point you in the right direction, give you feedback on your design, and help you find out if someone else is working on the same thing.
