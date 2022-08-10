FROM docker pull openresty/openresty:1.21.4.1-3-buster-fat
MAINTAINER Player FM <testdata@player.fm>

COPY nginx/testdata.conf /etc/nginx/sites-enabled/testdata.conf
COPY web /testdata
