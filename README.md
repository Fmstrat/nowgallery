# nowgallery
A simple web-app gallery for desktops, iOS, and Android.

This gallery takes a set of supplied source images in any folder structure you already have and generates small thumbnails and medium sized web images for display in a Progressive Web App.

**To do:**
- Docker HUB image
- Update documentation
- Manual install outside of docker
- Video support

## Install
The best way to install is to use Docker.
```
git clone https://github.com/Fmstrat/nowgallery.git
cd nowgallery
docker build --tag nowgallery .
```
With the following docker compose:
```
  nowgallery:
    image: nowgallery
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
This will create thumbnails and mid-sized images. Run once the container is active.
```
docker exec nowgallery php /scripts/scan.php
```
## Setting username/password for Web-app
Run once the container is active.
```
docker exec -ti nowgallery php /scripts/user.php
```
