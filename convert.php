<?php
require_once __DIR__ . '/vendor/autoload.php';

use YoutubeDl\YoutubeDl;

define("DOWNLOAD_FOLDER", dirname(__FILE__)."/download/"); //Be sure the chmod the download folder
define("DOWNLOAD_FOLDER_PUBLIC", "http://michaelbelgium.me/ytconverter/download/");
define("DOWNLOAD_MAX_LENGTH", 0); //max video duration (in seconds) to be able to download, set to 0 to disable

header("Content-Type: application/json");

if(isset($_GET["youtubelink"]) && !empty($_GET["youtubelink"]))
{
	$youtubelink = $_GET["youtubelink"];

	$success = preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $youtubelink, $matches);

	if(!$success)
		die(json_encode(array("error" => true, "message" => "No video specified")));

	$id = $matches[0];

	$exists = file_exists(DOWNLOAD_FOLDER.$id.".mp3");

	if(DOWNLOAD_MAX_LENGTH > 0 || $exists) {
		$dl = new YoutubeDl(['skip-download' => true]);
		$dl->setDownloadPath(DOWNLOAD_FOLDER);
	
		try {
			$video = $dl->download($youtubelink);
	
			if($video->getDuration() > DOWNLOAD_MAX_LENGTH && DOWNLOAD_MAX_LENGTH > 0)
				throw new Exception("Video too large. Max video length is ".DOWNLOAD_MAX_LENGTH." seconds.");
		}
		catch (Exception $ex)
		{
			die(json_encode(array("error" => true, "message" => $ex->getMessage())));
		}
	}

	if(!$exists)
	{		
		$dl = new YoutubeDl(array(
			'extract-audio' => true,
			'audio-format' => 'mp3',
			'audio-quality' => 0, 
			'output' => '%(id)s.%(ext)s',
			//'ffmpeg-location' => '/usr/local/bin/ffmpeg'
		));

		$dl->setDownloadPath(DOWNLOAD_FOLDER);
	}

	try 
	{
		$video = $dl->download($youtubelink);

		if($exists)
			$file = DOWNLOAD_FOLDER_PUBLIC.$id.".mp3";
		else
			$file = DOWNLOAD_FOLDER_PUBLIC.$video->getFilename();

		echo json_encode(array("error" => false, "title" => $video->getTitle(), "duration" => $video->getDuration(), "file" => $file));
	}
	catch (Exception $e)
	{
		echo json_encode(array("error" => true, "message" => $e->getMessage()));
	}
}
else if(isset($_GET["delete"]) && !empty($_GET["delete"]))
{
	$id = $_GET["delete"];

	if(unlink(DOWNLOAD_FOLDER.$id.".mp3"))
		echo json_encode(array("error" => false, "message" => "File removed"));
	else
		echo json_encode(array("error" => true, "message" => "File not found"));
}
else
	echo json_encode(array("error" => true, "message" => "Invalid request"));
?>