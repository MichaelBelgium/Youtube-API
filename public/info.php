<?php
use MichaelBelgium\YoutubeConverter\Config;

require_once __DIR__ . '/vendor/autoload.php';

header("Content-Type: application/json");

if (empty(Config::API_KEY))
{
    http_response_code(400);
    die(json_encode(['error' => true, 'message' => 'No API key set.']));
}

if (!isset($_GET['q']) && !isset($_GET['query']))
{
    http_response_code(400);
    die(json_encode(['error' => true, 'message' => 'Invalid request. Missing "q(uery)" parameter.']));
}

$query = $_GET['q'] ?? $_GET['query'];

if (filter_var($query, FILTER_VALIDATE_URL))
{
    $success = preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $query, $matches);
    if ($success)
        $id = $matches[0];
    else
    {
        http_response_code(400);
        die(json_encode(['error' => true, 'message' => 'No video specified.']));
    }
}
else
    $id = $query;

$client = new Google_Client();
$client->setDeveloperKey(Config::API_KEY);

$youtube_service = new Google_Service_YouTube($client);

$response = $youtube_service->videos->listVideos('snippet,contentDetails', ['id' => $id]);
$ytVideo = $response->getItems()[0] ?? null;

if ($ytVideo == null)
{
    http_response_code(404);
    die(json_encode(['error' => true, 'message' => 'Video not found.']));
}

$duration = $ytVideo->getContentDetails()->getDuration();
$interval = new \DateInterval($duration);
$duration = ($interval->h * 60 * 60) + ($interval->i * 60) + $interval->s;

echo json_encode([
    'error' => false,
    'id' => $id,
    'url' => 'https://youtube.com/watch?v='.$id,
    'channel_url' => 'https://youtube.com/channel/'.$ytVideo->getSnippet()->getChannelId(),
    'channel_id' => $ytVideo->getSnippet()->getChannelId(),
    'channel' => $ytVideo->getSnippet()->getChannelTitle(),
    'title' => $ytVideo->getSnippet()->getTitle(),
    'duration' => $duration,
    'description' => $ytVideo->getSnippet()->getDescription(),
    'published_at' => $ytVideo->getSnippet()->getPublishedAt()
]);