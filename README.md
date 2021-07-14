# Youtube-API

With these files you are able to create your own Youtube API with ability to search also.
See the [wiki](/wiki) for examples and demo.

## [Laravel version of this package](https://github.com/MichaelBelgium/Laravel-Youtube-API)

# Possible HTTP requests

## `GET - convert.php`

### *Convert a video*

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| youtubelink	| Yes	| string |  The full youtubelink of the video you want to download.  |
| format | No (default = mp3) | string: mp3 or mp4 | The format to download |
| delete | No | string | The youtubeid of which you want it to be deleted from storage on the server |

### *Delete a downloaded video*

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| delete | Yes | string | The youtubeid that has to be deleted from storage on the server |
| format | No (default = mp3 & mp4) | string: mp3 or mp4, leave empty to remove all | The format of the video that has to be deleted |

### Possible youtubelinks
```
youtube.com/v/{vidid}
youtube.com/vi/{vidid}
youtube.com/?v={vidid}
youtube.com/?vi={vidid}
youtube.com/watch?v={vidid}
youtube.com/watch?vi={vidid}
youtu.be/{vidid}
```

## `GET - search.php`

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| q	| Yes	| string | The query term to search for video's |
| max_results | No | integer | The max results of search results u want to get |

# Possible HTTP responses

## `JSON - convert.php`

| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| Whether or not an error occured |
| message	| string	| A simple message or the error message |


| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| false |
| youtube_id | string | The youtube identifier |
| title	| string	| The title of the video that got converted |
| alt_title | string | A secondary title of the video |
| duration	| integer	| The duration of the video that got converted (in seconds) |
| file	| string	| The streamlink or downloadable mp3 file |
| uploaded_at | object | A Date object |

## `JSON - search.php`

| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| Whether or not an error occured |
| message	| string	| An error message |
| results	| array	| An array with MAX_RESULTS entries. Each entry has: the video id, the channel name of the video, the video title and the full url to the video |

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

Setting options is available in `includes/config.php`

```PHP
// convert.php
define("DOWNLOAD_FOLDER", "download/"); //Be sure the chmod the download folder
define("DOWNLOAD_MAX_LENGTH", 0); //max video duration (in seconds) to be able to download, set to 0 to disable
define("LOG", false); //enable logging

// search.php
define("MAX_RESULTS", 10); //maximum results to show 
define("API_KEY", ""); //youtube api key from google
```

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
