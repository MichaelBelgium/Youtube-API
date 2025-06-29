FROM php:8.2-apache

#Get latest updates and install software needed
RUN apt-get update -qq \
    && apt-get upgrade -qq \
    && apt-get install -qq ffmpeg python3 wget curl net-tools unzip python3-dev python3-pip \
    && rm -rf /var/lib/apt/lists/*

# Upgrade pip, and install yt-dlp.
RUN curl -L -o yt-dlp https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp && chmod +x yt-dlp && mv yt-dlp /usr/bin/

#Get latest version of composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

#install the project and remove unnecessary files
RUN cd /var/www/html && rm -rf *
RUN /usr/local/bin/composer create-project michaelbelgium/youtube-to-mp3 . &&\
    rm -rf docker-compose.yml Docker* .gitignore .dockerignore  .github/ README.md

# Ensure permissions won't be a problem
RUN mkdir /var/www/.cache/ && chmod 777 /var/www/ -R

CMD ["apache2-foreground"]
