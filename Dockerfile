
FROM robertasolimandonofreo/debian_cherokee:latest 
ENV  GLPI_VERSION=9.5.6
USER root
RUN echo "UTC" > /etc/timezone

ENV PHP_EXTRA_CONFIGURE_ARGS=--enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data
WORKDIR /var/www/html/
RUN wget https://github.com/php/php-src/archive/refs/tags/php-8.0.0.tar.gz \
&& tar -xvzf php-8.0.0.tar.gz
RUN apt-get -y update \
    && apt-get -y dist-upgrade  \
    && apt-get -y --force-yes install \
    && apt install -y nginx \
    && systemctl enable nginx
RUN usermod -u 82 www-data \
    && groupmod -g 82 www-data

RUN mkdir code
RUN wget https://github.com/glpi-project/glpi/releases/download/${GLPI_VERSION}/glpi-${GLPI_VERSION}.tgz  -O /tmp/glpi.tgz 
RUN tar -C /code/ -xzf /tmp/glpi.tgz
RUN chown -R www-data:www-data /code/glpi
ADD glpi /etc/nginx/sites-available/glpi
ADD marketplace /code/glpi/marketplace
ADD plugins /code/glpi/plugins
RUN chmod -R 755 /code/glpi/
RUN chown -R www-data:www-data /code/glpi
RUN apt update \
    && apt -y upgrade 
WORKDIR /code/glpi

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list 
RUN wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
RUN apt update 
RUN apt-get install -y php8.0 php8.0-fpm php8.0-common php8.0-gmp php8.0-curl php8.0-intl php8.0-mbstring php8.0-xmlrpc php8.0-mysql php8.0-gd php8.0-imap php8.0-ldap php-cas php8.0-bcmath php8.0-xml php8.0-cli php8.0-zip php8.0-sqlite3
RUN ln -s /etc/nginx/sites-available/glpi /etc/nginx/sites-enabled/ 
RUN ln -s /usr/bin/php8 /usr/bin/php

COPY php.ini /etc/php/8.0/fpm/php.ini
ADD /config_db.php code/glpi/config/config_db.php
ADD www.conf /etc/php/8.0/fpm/pool.d
RUN systemctl enable php8.0-fpm 
RUN /etc/init.d/nginx restart
RUN /etc/init.d/php8.0-fpm restart
EXPOSE 9000
CMD ["nginx", "-g", "daemon off;"]
