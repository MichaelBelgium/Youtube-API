# Youtube-to-mp3-API

With these two php files you are able to create your own Youtube to MP3 API with ability to search also.

# Possible HTTP requests

* `GET - convert.php`

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| youtubelink	| Yes	| string |  The full youtubelink of the video you want to download |
| delete | No | string | The youtubeid of which you want it to be deleted from storage on the server |

* `GET - search.php`

| Parameter		| Required	| Type | Description |
|-----------|----------|-------------|-------------|
| q	| Yes	| string | The query term to search for video's |
| max_results | No | integer | The max results of search results u want to get |

# Possible HTTP responses

* `JSON - convert.php`

| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| Whether or not an error occured |
| message	| string	| A simple message or the error message |


| Parameter		|Type | Description |
|-----------|-------------|-------------|
| error	| boolean	| false |
| title	| string	| The title of the video that got converted |
| duration	| integer	| The duration of the video that got converted (in seconds) |
| file	| string	| The streamlink or downloadable mp3 file |

* `JSON - search.php`

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

* Install ffmpeg (+ libmp3lame - see below)
* [install youtube-dl](https://rg3.github.io/youtube-dl/download.html)

## Website

* Get a google developer api key
* Go to your webserver files to run composer into
* Run `composer create-project michaelbelgium/youtube-to-mp3 [directoryname]` - where `directoryname` is .. a directory where people can access the API from.
* Edit defines:

In `search.php` you can define these variables:
```PHP
define("MAX_RESULTS", 10);
define("API_KEY", "");
```

# How I installed ffmpeg (compiling/building and installing)

If you have ffmpeg in `yum` or `apt-get` this is **not needed**. I had to do this manually as I'm using Centos 6.x 

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

## Download/convert
`http://michaelbelgium.me/ytconverter/convert.php?youtubelink=https://www.youtube.com/watch?v=gUJKs1m7Y8M`

```JSON
{
	"error": false,
	"title": "Devin Wild & Sub Zero Project - Meltdown (Official Videoclip)",
	"duration": 210,
	"file": "http://michaelbelgium.me/ytconverter/download/gUJKs1m7Y8M.mp3"
}
```

## Search

`http://michaelbelgium.me/ytconverter/search.php?q=belgium&max_results=5`

```JSON
{
  "error": false,
  "message": null,
  "results": [
    {
      "channel": "FOOTBALL MINDS",
      "full_link": "https://youtube.com/watch?v=1Q6o3B5n_j4",
      "id": "1Q6o3B5n_j4",
      "title": "Belgium vs Japan 1-0 - Highlights & Goals - 14 November 2017"
    },
    {
      "channel": "Football Highlights & Goals",
      "full_link": "https://youtube.com/watch?v=v8DzbrQxXS8",
      "id": "v8DzbrQxXS8",
      "title": "BELGIUM vs MEXICO 3-3 ● All Goals & Highlights HD ● 10 Nov 2017 - FRIENDLY"
    },
    {
      "channel": "deielsio",
      "full_link": "https://youtube.com/watch?v=W3peC29XwOI",
      "id": "W3peC29XwOI",
      "title": "Lil Peep - Belgium [Unreleased]"
    },
    {
      "channel": "Geography Now",
      "full_link": "https://youtube.com/watch?v=0TuMvWCbM-g",
      "id": "0TuMvWCbM-g",
      "title": "Geography Now! Belgium"
    },
    {
      "channel": "Wolters World",
      "full_link": "https://youtube.com/watch?v=9SJiENN504M",
      "id": "9SJiENN504M",
      "title": "Visit Belgium - 5 Things You Will Love & Hate about Belgium"
    }
  ]
}
```