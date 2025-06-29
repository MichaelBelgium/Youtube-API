<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$dotenv->required(['DOWNLOAD_FOLDER', 'COOKIE_FILE'])->notEmpty();
$dotenv->ifPresent(['MAX_RESULTS', 'HOST_PORT', 'DOWNLOAD_MAX_LENGTH', 'ENABLE_LOG'])->isInteger();

function env(string $key, $default = null)
{
    if (!array_key_exists($key, $_ENV) || strlen($_ENV[$key]) == 0)
        return $default;

    return $_ENV[$key];
}