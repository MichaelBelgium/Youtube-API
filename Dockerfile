FROM php:7.4-apache

#Get latest updates and install software needed
RUN apt-get update -qq && apt-get upgrade -qq
RUN apt-get install -qq ffmpeg python3 wget curl net-tools unzip python3-dev python3-pip
RUN python3 -m pip install --upgrade youtube-dl

#Get latest version of composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

#install the project
RUN cd /var/www/html && rm -rf *
RUN /usr/local/bin/composer create-project michaelbelgium/youtube-to-mp3 .
RUN sed -E 's/.*API_KEY.*/public function _constructor() { $this->API_KEY = getenv("API_KEY"); }/' -i src/Config.php
RUN mkdir /var/www/.cache/ && chmod 777 /var/www/ -R
