# Change version
FROM nginx:1.21.4

COPY .docker/nginx/conf.d/laravel.conf /etc/nginx/conf.d/
COPY .docker/nginx/conf.d/vue.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html

RUN rm /etc/nginx/conf.d/default.conf
