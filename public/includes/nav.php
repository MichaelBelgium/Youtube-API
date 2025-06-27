<?php
$currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($currentPath === '') {
    $currentPath = '/';
}

$brandHref = ($currentPath === '/') ? '.' : '..';
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
