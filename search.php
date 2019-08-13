<?php

define("MAX_RESULTS", 10);
define("API_KEY", "");

require_once __DIR__ . '/vendor/autoload.php';

$result = array("error" => false, "message" => null, "results" => array());

header("Content-Type: application/json");

if (isset($_GET["q"]) && !empty($_GET["q"]))
{
    $max_results = MAX_RESULTS;

    if(isset($_GET["max_results"]) && !empty($_GET["max_results"]))
        $max_results = $_GET["max_results"];

    $client = new Google_Client();
    $client->setDeveloperKey(API_KEY);

    $youtube_service = new Google_Service_YouTube($client);

    try
    {
        $search = $youtube_service->search->listSearch("id,snippet", array(
            "q" => $_GET["q"],
            "maxResults" => $max_results,
            "type" => "video"
        ));

        foreach ($search["items"] as $searchResult)
        {
            $result["results"][] = array(
                "id" => $searchResult["id"]["videoId"],
                "channel" => $searchResult["snippet"]["channelTitle"],
                "title" => $searchResult["snippet"]["title"],
                "full_link" => "https://youtube.com/watch?v=".$searchResult["id"]["videoId"]
            );
        }

        $result["error"] = false;
    }
    catch (Exception $exception)
    {
        $json = json_decode($exception->getMessage());
        $result["error"] = true;
        $result["message"] = $json->error->message;
    }
}
else
{
    $result["error"] = true;
    $result["message"] = "Invalid request";
}

echo json_encode($result);
