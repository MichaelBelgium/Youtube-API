<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube to MP3</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="container-fluid">
        <?php include 'includes/nav.php'; ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Convert</h5>
                    </div>
                    <div class="card-body">
                        <form action="convert.php" method="get" id="frm-convert">
                            <div class="form-floating mb-3">
                                <input type="text" name="youtubelink" class="form-control" id="link" required placeholder="youtube.com" />
                                <label for="link">Youtube url</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-control" name="format" id="format">
                                    <option value="mp3">Audio (mp3)</option>
                                    <option value="mp4">Video (mp4)</option>
                                </select>
                                <label for="format">Format</label>
                            </div>
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-sync-alt"></i> Convert</button>
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
                                        <a target="_blank" class="btn btn-outline-primary disabled" href="#" id="download"><i class="fa fa-cloud-download" aria-hidden="true"></i> Listen/download</a>
                                        <a class="btn btn-outline-danger disabled" href="#" id="remove" data-id="">Remove</a>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Search</h5>
                    </div>
                    <div class="card-body">
                        <form action="search.php" method="get" id="frm-search">
                            <div class="form-floating mb-3">
                                <input type="text" name="q" class="form-control" id="q" required placeholder="search term" />
                                <label for="q">Search term</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="max_results" id="max_results" class="form-control" value="10" placeholder="number">
                                <label for="max_results">Maximum results</label>
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#frm-convert").submit(function(e) {
                $("#frm-convert button[type=submit]").html("<i class=\"fas fa-spin fa-sync-alt\"></i> Converting... Please wait");

                e.preventDefault();
                $.get($(this).attr("action"), { youtubelink: $('#link').val(), format: $('#format').val() },  function(data) {
                    $("#convert-response pre").text(JSON.stringify(data, null, 4));
                    $("#frm-convert button[type=submit]").html("<i class=\"fa fa-sync-alt\"></i> Convert");

                    if(data.error) {
                        $("#convert-response table tr:eq(0) td:last").html("<i class=\"fa fa-check\"></i>");
                        $("#convert-response table tr:eq(1) td:last").text(data.message);
                        $("#convert-response table tr:eq(2) td:last").text("-");
                        $("#convert-response table tr:eq(3) td:last").text(0);
                        $("#convert-response table tr:eq(4) td:last").text("-");
                        $("#convert-response table tr:eq(5) td:last").text("-");
                        
                        $("#download").attr("href", "#").addClass("disabled");
                        $("#remove").addClass("disabled");
                    } else {
                        $("#convert-response table tr:eq(0) td:last").html("<i class=\"fa fa-times\"></i>");
                        $("#convert-response table tr:eq(1) td:last").text("-");
                        $("#convert-response table tr:eq(2) td:last").text(data.title + " (" + data.alt_title + ")");
                        $("#convert-response table tr:eq(3) td:last").text(data.duration);
                        $("#convert-response table tr:eq(4) td:last").text(data.youtube_id);
                        $("#convert-response table tr:eq(5) td:last").text(new Date(data.uploaded_at.date));

                        $("#download").attr("href", data.file).removeClass("disabled");
                        $("#remove").removeClass("disabled").data("id", data.youtube_id);
                    }
                });
            });

            $("#remove").click(function() {
                $.get("convert.php", { delete: $(this).data("id") }, function(data) {
                    alert(data.message);
                });
            });

            $('#frm-search').submit(function (e) {
                e.preventDefault();

                $.get($(this).attr('action'), { q: $('#q').val(), max_results: $('#max_results').val() }, function (data) {

                    $("#search-response table tr:eq(2) td:last ul").empty();

                    if(data.error) {
                        $("#search-response table tr:eq(0) td:last").html("<i class=\"fa fa-check\"></i>");
                        $("#search-response table tr:eq(1) td:last").html(data.message);
                    } else {
                        $("#search-response table tr:eq(0) td:last").html("<i class=\"fa fa-times\"></i>");
                        $("#search-response table tr:eq(1) td:last").html('-');

                        Array.from(data.results).forEach( el => {
                            var btn = $('<button>', { class: 'ms-3 btn btn-sm btn-outline-secondary', text: 'Convert',  onclick: '$("#link").val("' + el.full_link + '"); return false;' });
                            var a = $('<a>', { href: el.full_link, text: el.title});
                            var item = $('<li>');
                            a.appendTo(item);
                            btn.appendTo(item);

                            item.appendTo('#search-response table tr:eq(2) td:last ul');
                        });
                    }

                    console.log(data);
                });
            });
        });
    </script>
</body>
</html>