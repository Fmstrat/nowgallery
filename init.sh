#!/bin/bash

if [ ! -d /git ]; then
	mkdir -p /git
fi
if [ ! -d /config ]; then
	mkdir -p /config
fi

if [ ! "$(ls -A /git)" ]; then
	cd /git
	git clone https://github.com/Fmstrat/nowgallery.git
	rm -rf /var/www/html
	ln -s /git/nowgallery/html /var/www/html
	ln -s /webimages /var/www/html/webimages
	ln -s /sourceimages /var/www/html/sourceimages
	ln -s /git/nowgallery/scripts /scripts
	cp /git/nowgallery/config/* /config
fi

cd /usr/local/bin
/usr/local/bin/apache2-foreground
