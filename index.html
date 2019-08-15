<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Youtube to MP3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
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
                    <input type="submit" class="btn btn-outline-primary" value="Convert">
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title">Json response</h5>
            </div>
            <div class="card-body">
                <code>{}</code>
            </div>
            <div class="card-footer">
                <table class="table table-borderless table-sm w-auto">
                    <tbody>
                        <tr>
                            <td>Error:</td>
                            <td><span id="error"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                        </tr>
                        <tr>
                            <td>Error message:</td>
                            <td><span id="error-message">-</span></td>
                        </tr>
                        <tr><td colspan="2"></td></tr>
                        <tr>
                            <td>Title:</td>
                            <td><span id="title">-</span></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><span id="duration">0</span> seconds</td>
                        </tr>
                        <tr>
                            <td><a class="btn btn-outline-primary disabled" href="#" id="download"><i class="fa fa-cloud-download" aria-hidden="true"></i> Listen/download</a></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#frm-convert").submit(function(e) {
                $("#frm-convert input[type=submit]").val("Converting... Please wait");

                e.preventDefault();
                $.get($(this).attr("action"), { youtubelink: $("#link").val() },  function(data) {
                    $("code").text(JSON.stringify(data));
                    $("#frm-convert input[type=submit]").val("Convert");

                    if(data.error) {
                        $("#error").html("<i class=\"fa fa-check\" aria-hidden=\"true\"></i>");
                        $("#error-message").text(data.message);

                        $("#duration").text(0);
                        $("#title").text("-");
                        $("#download").attr("href", "#");
                        $("#download").addClass("disabled");
                    } else {
                        $("#error").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i>");
                        $("#error-message").text("-");

                        $("#duration").text(data.duration);
                        $("#title").text(data.title);
                        $("#download").attr("href", data.file);
                        $("#download").removeClass("disabled");
                    }
                });
            });
        });
    </script>
</body>
</html>