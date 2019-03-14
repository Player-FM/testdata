FROM webdevops/php-nginx
MAINTAINER Player FM <testdata@player.fm>

COPY nginx/testdata.conf /etc/nginx/sites-enabled/testdata.conf
COPY . /testdata

ENTRYPOINT ["/testdata/bin/media.sh"]
