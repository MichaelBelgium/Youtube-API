<?php
require __DIR__ . '/vendor/autoload.php';

use YoutubeDl\YoutubeDl;
use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;

define("DOWNLOAD_FOLDER", "/var/www/html/lmdm/ucp/ytconverter/download");
define("DOWNLOAD_FOLDER_PUBLIC", "http://lmdm.exp-gaming.net/ucp/ytconverter/download/");

if(isset($_GET["youtubelink"]))
{
	$youtubelink = $_GET["youtubelink"];

	$dl = new YoutubeDl([
	    'extract-audio' => true,
	    'audio-format' => 'mp3',
	    'audio-quality' => 0, 
	    'output' => '%(title)s.%(ext)s',
	    'ffmpeg-location' => '/usr/local/bin/ffmpeg' //optional
	]);

	$dl->setDownloadPath(DOWNLOAD_FOLDER);

	header("Content-Type: application/json");
	try 
	{
		$video = $dl->download($youtubelink);
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


?>