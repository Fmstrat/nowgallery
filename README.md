# nowgallery
A simple web-app gallery for desktops, iOS, and Android.

This gallery takes a set of supplied source images in any folder structure you already have and generates small thumbnails and medium sized web images for display in a Progressive Web App.

## Install
The best way to install is to use Docker.
```
docker pull nowsci/nowgallery
```
With the following docker compose:
```
  nowgallery:
    image: nowsci/nowgallery
    container_name: nowgallery
    ports:
      - 80:80
    volumes:
      - ./nowgallery/images:/webimages
      - ./nowgallery/nowgallery.conf:/etc/nowgallery.conf:ro
      - /storage/Pictures:/sourceimages:ro
    restart: always
```
This would store any rendered thumbnails and medium sized images into `./nowgallery/images` based on existing source images in `/storage/Pictures`.

After you start the container, you can go back and edit `./nowgallery/nowgallery.conf` to change settings such as supplying a username and password.

Take a look at the Dockerfile for how to manually install.

## Scanning images
The best way to install is to use Docker.
