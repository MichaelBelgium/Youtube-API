<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ?>">Youtube converter</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavDropdown"
        aria-controls="mainNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/logs">Logs</a>
            </li>
        </ul>
    </div>
</nav>