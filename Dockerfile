FROM trafex/php-nginx
MAINTAINER Player FM <testdata@player.fm>

COPY nginx/testdata.conf /etc/nginx/conf.d
COPY web /var/www/html/
