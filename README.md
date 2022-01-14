# Youtube-API

With these files you are able to create your own Youtube API with ability to search also.

[Laravel version of this package](https://github.com/MichaelBelgium/Laravel-Youtube-API)

# Software requirements

* [youtube-dl](https://rg3.github.io/youtube-dl/)
* [ffmpeg](https://www.ffmpeg.org/) (+ [libmp3lame](http://lame.sourceforge.net/))

# General installation

First we install the dependencies on the server, then website.

## VPS

* Install ffmpeg (+ libmp3lame - see wiki for tutorial)
* [install youtube-dl](http://ytdl-org.github.io/youtube-dl/download.html)

## Website

* Get a google developer api key
* Go to your webserver files to run composer into
* Run `composer create-project michaelbelgium/youtube-to-mp3 [directoryname]` - where `directoryname` is .. a directory where people can access the API from.

## Configuration

Setting options are available in [`src/Config.php`](https://github.com/MichaelBelgium/Youtube-API/blob/master/src/Config.php)

## Documentation

Check out the [wiki](https://github.com/MichaelBelgium/Youtube-API/wiki) for more docs.

## docker-compose
You can deploy this API using `docker-compose.yml` and the `Dockerfile` to build from. Please add your google API Key to `docker-compose.yml`.
It will expose port 80 from the container, out to port 80 on the host. This can also be changed using the same file.

### How to run with docker-compose
Put docker-compose.yml and Dockerfile together in a new, empty folder.
Then, run the following command to get it running
```sh
sudo docker-compose up -d
```

To stop:
```sh
sudo docker-compose down
```
