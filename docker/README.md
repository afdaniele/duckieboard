# \\compose\\ in Docker

**\\compose\\** is also available as a Docker image.


## Build your own image using Dockerfile

You can download our Docker files from (here)[https://github.com/afdaniele/compose/tree/master/docker].
To build a Docker image from one of our Docker files run:

`docker build -t <image_name>:<image_tag> --build-arg VERSION=<github_compose_tag_name> .`

**NOTE:** `<github_compose_tag_name>` can be any (GitHub release)[https://github.com/afdaniele/compose/releases],
or `master` for the development version.


## Pre-built Docker images

These are the images that you can pull from your Docker console.

| Version   | Image tag                     | OS Host               | Web Server    | PHP   | Debug tools   |
| ----------|-------------------------------|-----------------------|---------------|-------|---------------|
| devel     | afdaniele/compose:devel       | Ubuntu 16.04.4 LTS    | Apache 2      | 7.0   | phpinfo, xDebug, WebGrind, apc.php |
| master    | afdaniele/compose:master      | Ubuntu 16.04.4 LTS    | Apache 2      | 7.0   | (none)        |
| v0.9      | afdaniele/compose:v0.9        | Ubuntu 16.04.4 LTS    | Apache 2      | 7.0   | (none)        |


## Run image with \\compose\\ outside the container (suggested)

Run

`docker run -d -p <PORT>:80 -e "BASEURL=<URL>:<PORT>" -v <COMPOSE_ROOT_HOST>:/var/www/html/public_html afdaniele/<COMPOSE_IMAGE>`

**NOTE:** If `<PORT>` is `80`, you can simply use `"BASEURL=<URL>"` instead of `"BASEURL=<URL>:<PORT>"`.


## Run image with \\compose\\ inside the container

**NOTE:** All the changes made in **\\compose\\** will be saved inside the container. If you delete the container without committing, all the changes will be lost.

Run

`docker run -d -p <PORT>:80 -e "BASEURL=<URL>:<PORT>" afdaniele/<COMPOSE_IMAGE>`

**NOTE:** If `<PORT>` is `80`, you can simply use `"BASEURL=<URL>"` instead of `"BASEURL=<URL>:<PORT>"`.