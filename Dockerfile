FROM php:8.2-apache

#Get latest updates and install software needed
RUN apt-get update -qq \
    && apt-get upgrade -qq \
    && apt-get install -qq ffmpeg python3 wget curl net-tools unzip python3-dev python3-pip \
    && rm -rf /var/lib/apt/lists/*

# Upgrade pip, and install yt-dlp.
RUN python3 -m pip install --upgrade yt-dlp pip

#Get latest version of composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

#install the project and remove unnecessary files
RUN cd /var/www/html && rm -rf *
RUN /usr/local/bin/composer create-project michaelbelgium/youtube-to-mp3 . &&\
    rm -rf docker-compose.yml Docker* .gitignore .dockerignore  .github/ README.md

# Ensure permissions won't be a problem
RUN mkdir /var/www/.cache/ && chmod 777 /var/www/ -R

# set new entrypoint and restore default command (apache). Entrypoint ensures
# the API key is written to src/Config.php on start, if not already set.
COPY docker-entrypoint.sh .
RUN chmod +x docker-entrypoint.sh
ENTRYPOINT ["./docker-entrypoint.sh"]
CMD ["apache2-foreground"]
