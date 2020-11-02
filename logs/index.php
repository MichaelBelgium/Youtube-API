<?php
    $files = glob(__DIR__ . '/*.log');

    $data = [];
    $first = null;

    foreach ($files as $filePath) {
        $name = pathinfo($filePath, PATHINFO_FILENAME);
        if($first === null) $first = $name;
        
        $data[$name] = [];

        $file = new SplFileObject($filePath);
        
        while(!$file->eof()) {
            $line = $file->fgets();
            $parts = explode(' ', $line, 2);

            $data[$name][] = [
                DateTime::createFromFormat('Ymd [H:i:s]', $name . ' ' . $parts[0]),
                json_decode($parts[1])
            ];
        }

        unset($data[$name][count($data[$name]) - 1]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
</head>
<body class="container-fluid">
    <select class="form-control my-4" name="log" onchange="onLogSelect();">
        <?php foreach($data as $name => $dates): ?>
        <option value="<?= $name ?>">
            <?= DateTime::createFromFormat('Ymd', $name)->format('d F Y'); ?>
        </option>
        <?php endforeach; ?>
    </select>

    <?php foreach ($data as $name => $array): ?>
        <div class="result <?= $first == $name ? '' : 'd-none' ?>" id="<?= $name ?>">
            <table class="table w-100">
                <thead>
                    <tr>
                        <td>Datetime</td>
                        <td>ID</td>
                        <td>Title</td>
                        <td>Duration</td>
                        <td>Location</td>
                    </tr>
                </thead>
                <tbody>
                    
                <?php foreach ($array as $value): ?>
                    <tr>
                        <td><?= $value[0]->format('H:i:s'); ?></td>
                        <td><?= $value[1]->youtube_id; ?></td>
                        <td><?= $value[1]->title; ?></td>
                        <td><?= $value[1]->duration; ?> seconds</td>
                        <td>
                            <?php if(file_exists('../download/'.basename($value[1]->file))): ?>
                            <a href="<?= $value[1]->file; ?>" target="_blank">Converted file</a>
                            <?php else: ?>
                            Removed
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table').DataTable();
        });

        function onLogSelect() {
            var selected = $('select[name=log] option:selected').val();

            $('.result').each(function(index, el) {
                $(el).addClass('d-none');
            });

            $('#' + selected).removeClass('d-none');
        }
    </script>
</body>
</html>