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
* [install youtube-dl](http://ytdl-org.github.io/youtube-dl/download.html) or [yt-dlp](https://github.com/yt-dlp/yt-dlp/releases/latest)

## Website

* Get a google developer api key
* Go to your webserver files to run composer into
* Run `composer create-project michaelbelgium/youtube-to-mp3 [directoryname]` - where `directoryname` is .. a directory where people can access the API from.

## Configuration

Setting options are available in [`src/Config.php`](https://github.com/MichaelBelgium/Youtube-API/blob/master/src/Config.php)

## Documentation

Check out the [wiki](https://github.com/MichaelBelgium/Youtube-API/wiki) for more docs.

## Docker
You can deploy this API using `docker-compose.yml` and the `Dockerfile` to build from. Please add your google API Key to the `.env` file.
It will expose port 80 from the container, out to port 80 on the host. This can also be changed in `.env` under HOST_PORT. The docker image uses yt-dlp.

### How to run with docker-compose
Put docker-compose.yml and Dockerfile together in a new, empty folder. Create `.env`, and set the values listed in the example `.env` in this repo.
To run, use the following command:
```sh
docker-compose up -d
```

To stop:
```sh
docker-compose down
# Or use this to remove the attached volume, to clear up space-
docker-compose down -v
```

### Changing API Key?
If you are changing your API key, the change will not reflect until you have removed the attached docker volume and restarted the container. Another option is to enter the container and go to `src/Config.php` and manually change it, or mount the config in as a separate volume.