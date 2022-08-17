FROM trafex/php-nginx:2.5.0
MAINTAINER Player FM <testdata@player.fm>

USER root
RUN apk add php8-fileinfo

USER nobody
COPY nginx/testdata.conf /etc/nginx/nginx.conf
COPY web /var/www/html
