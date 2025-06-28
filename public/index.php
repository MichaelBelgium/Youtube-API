<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube to MP3</title>
    
    <?php include 'includes/styles.php'; ?>
</head>
<body>
    <div class="container-fluid">
        <?php include 'includes/nav.php'; ?>

        <div class="row mt-2">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Convert</h5>
                    </div>

                    <div class="card-body">
                        <form action="convert.php" method="get" id="frm-convert">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="youtubelink" class="form-control" id="link" onchange="fillStartEnd()" onkeyup="fillStartEnd()" required placeholder=" " />
                                        <label for="link">Youtube url</label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-control" name="format" id="format">
                                            <option value="mp3">Audio (mp3)</option>
                                            <option value="mp4">Video (mp4)</option>
                                        </select>
                                        <label for="format">Format</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-forward-step"></i>
                                        </span>

                                        <div class="form-floating">
                                            <input type="number" class="form-control" min="0" name="startAt" id="startAt" placeholder=" " />
                                            <label for="startAt">Start</label>
                                        </div>

                                        <div class="form-floating">
                                            <input type="number" class="form-control" min="0" name="endAt" id="endAt" placeholder=" " />
                                            <label for="endAt">End</label>
                                        </div>

                                        <span class="input-group-text">
                                            <i class="fa-solid fa-backward-step"></i>
                                        </span>
                                    </div>
                                    <div class="form-text">
                                        Specify start and/or end times <b>(in seconds)</b> to trim the video. Leave both empty to download the complete video.<br/>
                                        Start time only: downloads from that point to the end. End time only: downloads from the beginning to that point.
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-primary mt-4"><i class="fas fa-sync-alt"></i> Convert</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3" id="convert-response">
                    <div class="card-header">
                        <h5 class="card-title">Json response</h5>
                    </div>
                    <div class="card-body">
                        <pre>{}</pre>
                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless table-sm w-auto">
                            <tbody>
                                <tr>
                                    <td>Error:</td>
                                    <td><i class="fa fa-times" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>Error message:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Title:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td><span id="duration">0</span> seconds</td>
                                </tr>
                                <tr>
                                    <td>Youtube ID</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Uploaded at</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a target="_blank" class="btn btn-outline-primary disabled" href="#" id="download"><i class="fas fa-cloud-download-alt"></i> Listen/download</a>
                                        <a class="btn btn-outline-danger disabled" href="#" id="remove" data-id=""><i class="fas fa-trash-alt"></i> Remove</a>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Search</h5>
                    </div>
                    <div class="card-body">
                        <form action="search.php" method="get" id="frm-search">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="q" class="form-control" id="q_search" required placeholder="search term" />
                                        <label for="q_search">Search term</label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="max_results" id="max_results" class="form-control" value="10" placeholder="number">
                                        <label for="max_results">Maximum results</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Search</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3" id="search-response">
                    <div class="card-header">
                        <h5 class="card-title">Json response</h5>
                    </div>
                    <div class="card-body">
                        <pre>{}</pre>
                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless table-sm w-auto">
                            <tbody>
                                <tr>
                                    <td>Error:</td>
                                    <td><i class="fa fa-times"></i></td>
                                </tr>
                                <tr>
                                    <td>Error message:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Results:</td>
                                    <td><ul></ul></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Info</h5>
                    </div>
                    <div class="card-body">
                        <form action="info.php" method="get" id="frm-info">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="q" class="form-control" id="q_info" required placeholder="" />
                                        <label for="q_info">Youtube ID or url</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Retrieve info</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3" id="info-response">
                    <div class="card-header">
                        <h5 class="card-title">Json response</h5>
                    </div>
                    <div class="card-body">
                        <pre>{}</pre>
                    </div>
                    <div class="card-footer">
                        <table class="table table-borderless table-sm w-auto">
                            <tbody>
                            <tr>
                                <td>Error:</td>
                                <td><i class="fa fa-times"></i></td>
                            </tr>
                            <tr>
                                <td>Error message:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Channel:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Channel ID:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Channel URL:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Duration:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>ID:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Published at:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Title:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>URL:</td>
                                <td>-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>