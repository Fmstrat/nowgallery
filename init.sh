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
fi
if [ ! -L /var/www/html ]; then
	rm -rf /var/www/html
	ln -s /git/nowgallery/html /var/www/html
fi
if [ ! -L /var/www/html/webimages ]; then
	ln -s /webimages /var/www/html/webimages
fi
if [ ! -L /var/www/html/sourceimages ]; then
	ln -s /sourceimages /var/www/html/sourceimages
fi
if [ ! -L /scripts ]; then
	ln -s /git/nowgallery/scripts /scripts
fi
if [ ! -f /config/nowgallery.conf ]; then
	cp /git/nowgallery/config/nowgallery.conf /config
fi
if [ ! -L /etc/nowgallery.conf ]; then
	ln -s /config/nowgallery.conf /etc/nowgallery.conf
fi

cd /usr/local/bin
/usr/local/bin/apache2-foreground
