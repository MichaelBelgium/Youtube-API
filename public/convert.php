<?php
require 'includes/env.php';

use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

header("Content-Type: application/json");

const POSSIBLE_FORMATS = ['mp3', 'mp4'];

if(isset($_GET["youtubelink"]) && !empty($_GET["youtubelink"]))
{
    $youtubelink = $_GET["youtubelink"];
    $startAt = $_GET["startAt"] ?? null;
    $endAt = $_GET["endAt"] ?? null;
    $format = $_GET['format'] ?? 'mp3';

    if(!in_array($format, POSSIBLE_FORMATS))
    {
        http_response_code(400);
        die(json_encode(array("error" => true, "message" => "Invalid format: only mp3 or mp4 are possible")));
    }

    $success = preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $youtubelink, $matches);

    if(!$success)
    {
        http_response_code(400);
        die(json_encode(array("error" => true, "message" => "No video specified")));
    }

    $id = $matches[0];

    $exists = file_exists(env('DOWNLOAD_FOLDER').$id.".".$format);

    if (!empty($startAt) || !empty($endAt))
    {
        if (!empty($startAt) && !empty($endAt))
        {
            if ((int)$startAt >= (int)$endAt)
            {
                http_response_code(400);
                die(json_encode(array("error" => true, "message" => "Invalid time range: startAt must be less than endAt")));
            }
        }

        $query = parse_url($youtubelink, PHP_URL_QUERY);
        parse_str($query, $params);

        if (!empty($startAt))
            $params['start'] = $startAt;

        if (!empty($endAt))
            $params['end'] = $endAt;

        $youtubelink = strtok($youtubelink, '?') . '?' . http_build_query($params);

        if ($exists)
        {
            //todo this can probably go when youtube-dl-php supports --force-overwrites options
            unlink(env('DOWNLOAD_FOLDER').$id.".".$format);
            $exists = false;
        }
    }

    if(env('DOWNLOAD_MAX_LENGTH', 0) > 0 || $exists)
    {
        try	{
            $dl = new YoutubeDl();

            $video = $dl->download(
                Options::create()
                    ->noPlaylist()
                    ->proxy(env('PROXY'))
                    ->skipDownload(true)
                    ->downloadPath(env('DOWNLOAD_FOLDER'))
                    ->cookies(file_exists(env('COOKIE_FILE')) ? env('COOKIE_FILE') : null)
                    ->url($youtubelink)
            )->getVideos()[0];

            if ($video->getError() !== null)
                throw new Exception($video->getError());
    
            if($video->getDuration() > env('DOWNLOAD_MAX_LENGTH', 0) && env('DOWNLOAD_MAX_LENGTH', 0) > 0)
                throw new Exception("The duration of the video is {$video->getDuration()} seconds while max video length is ".env('DOWNLOAD_MAX_LENGTH')." seconds.");
        }
        catch (Exception $ex)
        {
            http_response_code(400);
            die(json_encode(array("error" => true, "message" => $ex->getMessage())));
        }
    }

    if(!$exists)
    {
        $options = Options::create()
            ->output('%(id)s.%(ext)s')
            ->downloadPath(env('DOWNLOAD_FOLDER'))
            ->proxy(env('PROXY'))
            ->noPlaylist()
            ->cookies(file_exists(env('COOKIE_FILE')) ? env('COOKIE_FILE') : null)
            ->url($youtubelink);

        if (!empty($startAt) || !empty($endAt))
            $options = $options->downloadSections('*from-url');

        if($format == 'mp3')
        {
            $options = $options->extractAudio(true)
                ->audioFormat('mp3')
                ->audioQuality('0');
        }
        else
            $options = $options->format('bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]/best');
    }

    try
    {
        $dirname = dirname($_SERVER['PHP_SELF']);
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .
            ($dirname == '/' ? '' : $dirname) . "/";

        if($exists)
            $file = $url.env('DOWNLOAD_FOLDER').$video->getId().'.'.$format;
        else
        {
            $dl = new YoutubeDl();
            
            $video = $dl->download($options)->getVideos()[0];

            if($video->getError() !== null)
                die(json_encode(array("error" => true, "message" => $video->getError())));

            $file = $url.$video->getFilename();
        }

        $json = json_encode(array(
            "error" => false,
            "youtube_id" => $video->getId(),
            "title" => $video->getTitle(),
            "alt_title" => $video->getAltTitle(),
            "duration" => $video->getDuration(),
            "file" => $file,
            "uploaded_at" => $video->getUploadDate()
        ));

        if(env('ENABLE_LOG', false))
        {
            $now = new DateTime();
            $file = fopen('logs/'.$now->format('Ymd').'.log', 'a');
            fwrite($file, '[' . $now->format('H:i:s') . '] ' . $json . PHP_EOL);
            fclose($file);
        }

        echo $json;
    }
    catch (Exception $e)
    {
        http_response_code(400);
        echo json_encode(array("error" => true, "message" => $e->getMessage()));
    }
}
else if(isset($_GET["delete"]) && !empty($_GET["delete"]))
{
    $id = $_GET["delete"];
    $format = $_GET["format"] ?? POSSIBLE_FORMATS;

    if(empty($format))
        $format = POSSIBLE_FORMATS;

    if(!is_array($format))
        $format = [$format];

    $removedFiles = [];

    foreach($format as $f) {
        $localFile = env('DOWNLOAD_FOLDER').$id.".".$f;
        if(file_exists($localFile)) {
            unlink($localFile);
            $removedFiles[] = $f;
        }
    }
    
    $resultNotRemoved = array_diff(POSSIBLE_FORMATS, $removedFiles);

    if(empty($removedFiles))
        $message = 'No files removed.';
    else
        $message = 'Removed files: ' . implode(', ', $removedFiles) . '.';

    if(!empty($resultNotRemoved))
        $message .= ' Not removed: ' . implode(', ', $resultNotRemoved);

    echo json_encode(array(
        "error" => false,
        "message" => $message
    ));
}
else
{
    http_response_code(400);
    echo json_encode(array("error" => true, "message" => "Invalid request: missing 'youtubelink' parameter"));
}
?>