FROM robertasolimandonofreo/debian_cherokee:latest 
ENV                 GLPI_VERSION=9.5.6

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
RUN chmod 777 /code/glpi/
ADD marketplace /code/glpi/marketplace
ADD plugins /code/glpi/plugins
RUN chown -R www-data:www-data /code/glpi
RUN apt update \
    && apt -y upgrade 

CMD ["nginx", "-g", "daemon off;"]