FROM alpine:latest


RUN apk add --update php

ADD . /app

WORKDIR /app

CMD php -S 0.0.0.0:$PORT