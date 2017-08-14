# Youtube-to-mp3-API

By using these you are able to make your own Youtube-to-MP3 API, mostly thanks to the requirement libraries.

# Requirements

* [youtube-dl](https://rg3.github.io/youtube-dl/)
* [ffmpeg](https://www.ffmpeg.org/)
* [libmp3lame](http://lame.sourceforge.net/) 
* [youtube-dl-php](https://github.com/norkunas/youtube-dl-php)

# General installation

First we install the dependencies on the server, then website.

## VPS

* Install libmp3lame (see below)
* Install ffmpeg (see below)
* install youtube-dl

## Website

* Go to a directory to run composer into (this will be the directory where you'll access the API via browser)
* Install youtube-dl-php (or just do `composer require norkunas/youtube-dl-php`)
* Put the `convert.php` in the same directory (the file in this repo is an example. It's the file I use on my VPS.)


# How I installed ffmpeg (compiling/building and installing)

If you have ffmpeg in `yum` or `apt-get` or any kind this is probably not needed. I had to do this manually as I'm using Centos 6.x 

## libmp3lame

First i had to install `libmp3lame` - ffmpeg uses this.

```
mkdir ffmpeg_sources && cd ffmpeg_sources
wget http://downloads.sourceforge.net/project/lame/lame/3.99/lame-3.99.5.tar.gz
tar xzvf lame-3.99.5.tar.gz
cd lame-3.99.5
./configure
make
make install
lame
```

## ffmpeg

Then ffmpeg; I work with Centos 6.x so the most updated ffmpeg is not available in `yum`

```
wget https://www.ffmpeg.org/releases/ffmpeg-3.3.2.tar.gz
tar xfz ffmpeg-3.3.2.tar.gz
cd ffmpeg-3.3.2
./configure --enable-libmp3lame --disable-yasm
make
make install
```

Aftwards ffmpeg was installed in `/usr/local/bin/ffmpeg` which then I needed to specify in `convert.php`

# Example output

```JSON
{
	"error": false,
	"title": "Devin Wild & Sub Zero Project - Meltdown (Official Videoclip)",
	"duration": 210,
	"file": "http://michaelbelgium.me/ytconverter/download/gUJKs1m7Y8M.mp3"
}
```