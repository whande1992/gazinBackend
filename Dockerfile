FROM wyveo/nginx-php-fpm:latest
WORKDIR /var/www/
RUN rm /etc/nginx/conf.d/default.conf
RUN rm -rf /usr/share/nginx/html
RUN ln -s public/ html
RUN apt-get -y update
RUN apt-get -y install php8.1-sqlite3

