FROM alpine:3.12.3

ENV APP_HOME /app
WORKDIR ${APP_HOME}

COPY laravel-echo-server.json laravel-echo-server.json

RUN apk add nodejs npm

RUN npm install -g laravel-echo-server

CMD ["laravel-echo-server", "start"]

EXPOSE 6001