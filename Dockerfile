FROM webdevops/php-nginx:7.4
MAINTAINER Player FM <testdata@player.fm>

RUN wget -O "/usr/local/bin/go-replace" "https://github.com/webdevops/goreplace/releases/download/1.1.2/gr-arm64-linux" \
    && chmod +x "/usr/local/bin/go-replace" \
    && "/usr/local/bin/go-replace" --version

COPY nginx/testdata.conf /etc/nginx/sites-enabled/testdata.conf
COPY web /testdata
