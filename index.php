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
    <div class="p-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Youtube to mp3</h5>
            </div>
            <div class="card-body">
                <form action="convert.php" method="post" id="frm-convert">
                    <div class="form-group">
                        <input type="text" name="youtubelink" class="form-control" id="link" placeholder="Youtube url" required />
                    </div>
                    <div class="form-group">
                        <label for="format">Format</label>
                        <select class="form-control" name="format" id="format">
                            <option value="mp3">Audio (mp3)</option>
                            <option value="mp4">Video (mp4)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary"><i class="fa fa-refresh" aria-hidden="true"></i> Convert</button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#frm-convert").submit(function(e) {
                $("#frm-convert button[type=submit]").html("<i class=\"fas fa-spin fa-sync-alt\"></i> Converting... Please wait");

                e.preventDefault();
                $.get($(this).attr("action"), { youtubelink: $('#link').val(), format: $('#format').val() },  function(data) {
                    $("pre").text(JSON.stringify(data, null, 4));
                    $("#frm-convert button[type=submit]").html("<i class=\"fa fa-sync-alt\"></i> Convert");

                    if(data.error) {
                        $("table tr:eq(0) td:last").html("<i class=\"fa fa-check\"></i>");
                        $("table tr:eq(1) td:last").text(data.message);
                        $("table tr:eq(2) td:last").text("-");
                        $("table tr:eq(3) td:last").text(0);
                        $("table tr:eq(4) td:last").text("-");
                        $("table tr:eq(5) td:last").text("-");
                        
                        $("#download").attr("href", "#").addClass("disabled");
                        $("#remove").addClass("disabled");
                    } else {
                        $("table tr:eq(0) td:last").html("<i class=\"fa fa-times\"></i>");
                        $("table tr:eq(1) td:last").text("-");
                        $("table tr:eq(2) td:last").text(data.title + " (" + data.alt_title + ")");
                        $("table tr:eq(3) td:last").text(data.duration);
                        $("table tr:eq(4) td:last").text(data.youtube_id);
                        $("table tr:eq(5) td:last").text(new Date(data.uploaded_at.date));

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
        });
    </script>
</body>
</html>