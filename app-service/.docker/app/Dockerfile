# Builder
FROM node:12-alpine as builder

ENV APP_HOME /app
WORKDIR ${APP_HOME}

COPY . .
COPY .env.production .env

ARG APP_KEY
ARG APP_URL
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG REDIS_HOST
ARG REDIS_PORT
ARG MAIL_HOST
ARG MAIL_PORT
ARG MAIL_USERNAME
ARG MAIL_PASSWORD
ARG MAIL_ENCRYPTION
ARG ADMIN_EMAIL
ARG ADMIN_PASS
ARG BASE_FAAS_URL
ARG FCM_SERVER_KEY
ARG MIX_FIREBASE_API_KEY
ARG MIX_FIREBASE_AUTH_DOMAIN
ARG MIX_FIREBASE_DB_URL
ARG MIX_FIREBASE_PROJECT_ID
ARG MIX_FIREBASE_STORAGE_BUCKET
ARG MIX_FIREBASE_MESSAGING_SENDER_ID
ARG MIX_FIREBASE_APP_ID
ARG MIX_FIREBASE_MEASUREMENT_ID
ARG MIX_FIREBASE_PREFIX

RUN sed -i 's@APP_KEY=@APP_KEY='"${APP_KEY}"'@' ${APP_HOME}/.env && \
    sed -i 's@APP_URL=@APP_URL='"${APP_URL}"'@' ${APP_HOME}/.env && \
    sed -i 's@DB_HOST=@DB_HOST='"${DB_HOST}"'@' ${APP_HOME}/.env && \
    sed -i 's@DB_PORT=@DB_PORT='"${DB_PORT}"'@' ${APP_HOME}/.env && \
    sed -i 's@DB_DATABASE=@DB_DATABASE='"${DB_DATABASE}"'@' ${APP_HOME}/.env && \
    sed -i 's@DB_USERNAME=@DB_USERNAME='"${DB_USERNAME}"'@' ${APP_HOME}/.env && \
    sed -i 's@DB_PASSWORD=@DB_PASSWORD='"${DB_PASSWORD}"'@' ${APP_HOME}/.env && \
    sed -i 's@REDIS_HOST=@REDIS_HOST='"${REDIS_HOST}"'@' ${APP_HOME}/.env && \
    sed -i 's@REDIS_PORT=@REDIS_PORT='"${REDIS_PORT}"'@' ${APP_HOME}/.env && \
    sed -i 's@MAIL_HOST=@MAIL_HOST='"${MAIL_HOST}"'@' ${APP_HOME}/.env && \
    sed -i 's@MAIL_PORT=@MAIL_PORT='"${MAIL_PORT}"'@' ${APP_HOME}/.env && \
    sed -i 's/MAIL_USERNAME=/MAIL_USERNAME='"${MAIL_USERNAME}"'/' ${APP_HOME}/.env && \
    sed -i 's@MAIL_PASSWORD=@MAIL_PASSWORD='"${MAIL_PASSWORD}"'@' ${APP_HOME}/.env && \
    sed -i 's@MAIL_ENCRYPTION=@MAIL_ENCRYPTION='"${MAIL_ENCRYPTION}"'@' ${APP_HOME}/.env && \
    sed -i 's/ADMIN_EMAIL=/ADMIN_EMAIL='"${ADMIN_EMAIL}"'/' ${APP_HOME}/.env && \
    sed -i 's/ADMIN_PASS=/ADMIN_PASS='"${ADMIN_PASS}"'/' ${APP_HOME}/.env && \
    sed -i 's@BASE_FAAS_URL=@BASE_FAAS_URL='"${BASE_FAAS_URL}"'@' ${APP_HOME}/.env && \
    sed -i 's@FCM_SERVER_KEY=@FCM_SERVER_KEY='"${FCM_SERVER_KEY}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_API_KEY=@MIX_FIREBASE_API_KEY='"${MIX_FIREBASE_API_KEY}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_AUTH_DOMAIN=@MIX_FIREBASE_AUTH_DOMAIN='"${MIX_FIREBASE_AUTH_DOMAIN}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_DB_URL=@MIX_FIREBASE_DB_URL='"${MIX_FIREBASE_DB_URL}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_PROJECT_ID=@MIX_FIREBASE_PROJECT_ID='"${MIX_FIREBASE_PROJECT_ID}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_STORAGE_BUCKET=@MIX_FIREBASE_STORAGE_BUCKET='"${MIX_FIREBASE_STORAGE_BUCKET}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_MESSAGING_SENDER_ID=@MIX_FIREBASE_MESSAGING_SENDER_ID='"${MIX_FIREBASE_MESSAGING_SENDER_ID}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_APP_ID=@MIX_FIREBASE_APP_ID='"${MIX_FIREBASE_APP_ID}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_MEASUREMENT_ID=@MIX_FIREBASE_MEASUREMENT_ID='"${MIX_FIREBASE_MEASUREMENT_ID}"'@' ${APP_HOME}/.env && \
    sed -i 's@MIX_FIREBASE_PREFIX=@MIX_FIREBASE_PREFIX='"${MIX_FIREBASE_PREFIX}"'@' ${APP_HOME}/.env

RUN yarn && yarn prod

# Set master image
FROM php:7.2-fpm-alpine

# Set Workdir
ENV APP_HOME /app
WORKDIR ${APP_HOME}

# Copy file to image
COPY --from=builder /app/ ${APP_HOME}

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install Additional dependencies
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    bcmath \
    redis \
    pdo_mysql \
    zip

RUN apk update && apk add \
        shadow \
        nginx \
        supervisor \
        bash

# Install dependencies
RUN php -r "copy ('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink ('composer-setup.php');" \
    && php composer.phar install --no-dev --no-scripts --prefer-dist \
    && php composer.phar clearcache \
    && rm composer.phar

RUN php artisan migrate
RUN php artisan view:cache
RUN php artisan config:cache
RUN php artisan route:cache

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# RUN chown -R www-data:www-data .

# Add cron
RUN echo "*   *   *   *   *   cd ${APP_HOME} && php artisan schedule:run >> /dev/null 2>&1" >> /var/spool/cron/crontabs/root

RUN mkdir -p /etc/nginx /etc/nginx/sites-available /etc/nginx/sites-enabled /run/nginx && \
    ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

COPY .docker/app/default.conf /etc/nginx/conf.d/default.conf
COPY .docker/app/ssl/ /etc/ssl/
COPY .docker/app/supervisord.conf /etc/

# Run PHP-FPM with Nginx
ENTRYPOINT /usr/bin/supervisord -c /etc/supervisord.conf

EXPOSE 80 443
