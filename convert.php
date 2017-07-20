<?php
require __DIR__ . '/vendor/autoload.php';

use YoutubeDl\YoutubeDl;
use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;

define("DOWNLOAD_FOLDER", "/var/www/html/lmdm/ucp/ytconverter/download/");
define("DOWNLOAD_FOLDER_PUBLIC", "http://lmdm.exp-gaming.net/ucp/ytconverter/download/");

header("Content-Type: application/json");

if(isset($_GET["youtubelink"]) && !empty($_GET["youtubelink"]))
{
	$youtubelink = $_GET["youtubelink"];

	parse_str(parse_url($youtubelink, PHP_URL_QUERY), $queryvars);
	$id = $queryvars["v"];
	$file = DOWNLOAD_FOLDER.$id.".mp3";

	$exists = file_exists($file);
	if($exists)
	{
		$options = [
		    'skip-download' => true
		];
	}
	else
	{
		$options = [
		    'extract-audio' => true,
		    'audio-format' => 'mp3',
		    'audio-quality' => 0, 
		    'output' => '%(id)s.%(ext)s',
		    'ffmpeg-location' => '/usr/local/bin/ffmpeg' //optional
		];
	}
	$dl = new YoutubeDl($options);

	$dl->setDownloadPath(DOWNLOAD_FOLDER);

	try 
	{
		$video = $dl->download($youtubelink);

		if($exists)
			$file = DOWNLOAD_FOLDER_PUBLIC.$id.".mp3";
		else
			$file = DOWNLOAD_FOLDER_PUBLIC . $video->getFilename();

		echo "{ \"error\": false, \"title\": \"{$video->getTitle()}\", \"duration\": {$video->getDuration()}, \"file\": \"$file\" }";
	} 
	catch (NotFoundException $e) 
	{
	   echo "{ \"error\" : true, \"type\": \"NotFoundException\" } ";
	} 
	catch (PrivateVideoException $e) 
	{
	    echo "{ \"error\" : true, \"type\": \"PrivateVideoException\" } ";
	} 
	catch (CopyrightException $e) 
	{
	    echo "{ \"error\" : true, \"type\": \"CopyrightException\" } ";
	} 
	catch (Exception $e) 
	{
	    echo "{ \"error\" : true, \"type\": \"Exception\" }";
	}
}
else if(isset($_GET["delete"]) && !empty($_GET["delete"]))
{
	$id = $_GET["delete"];

	if(unlink(DOWNLOAD_FOLDER.$id.".mp3"))
		echo "{ \"error\" : false, \"message\": \"File removed\" }";
	else
		echo "{ \"error\" : true, \"type\": \"FileNotFound\" }";
}
?>