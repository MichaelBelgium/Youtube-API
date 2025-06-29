<?php

require 'includes/env.php';

$result = array("error" => false, "message" => null, "results" => array());

header("Content-Type: application/json");

if (env('API_KEY') === null)
{
    http_response_code(400);
    die(json_encode(['error' => true, 'message' => 'No API key set.']));
}

if (isset($_GET["q"]) && !empty($_GET["q"]))
{
    $max_results = env('MAX_RESULTS', 10);

    if(isset($_GET["max_results"]) && !empty($_GET["max_results"]))
        $max_results = $_GET["max_results"];

    $client = new Google_Client();
    $client->setDeveloperKey(env('API_KEY'));

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
        http_response_code(400);
        $json = json_decode($exception->getMessage());
        $result["error"] = true;
        $result["message"] = $json->error->message;
    }
}
else
{
    http_response_code(400);
    $result["error"] = true;
    $result["message"] = "Invalid request. Missing 'q' parameter.";
}

echo json_encode($result);
