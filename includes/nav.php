<?php
// Get the path from the request URI and remove any trailing slash.
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// If the path is empty, assume it's the root.
if ($currentPath === '') {
    $currentPath = '/';
}

// Use the basename function to check if we're in the "logs" folder.
$brandHref = (basename($currentPath) === 'logs') ? '..' : '.';
$logsHref  = (basename($currentPath) === 'logs') ? '.' : 'logs';
?>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="<?= $brandHref ?>">Youtube converter</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavDropdown"
        aria-controls="mainNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= $logsHref ?>">Logs</a>
            </li>
        </ul>
    </div>
</nav>
