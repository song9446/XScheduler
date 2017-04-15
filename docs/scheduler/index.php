<?php
ini_set('upload_tmp_dir','/home/song/Projects/XScheduler/docs/tmp/');
?>
<html>
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="calendar.css"></link>
    <link rel="stylesheet" href="scheduler.css"></link>
    <title> UniScheduler </title>
    </head>
    <body>
    <script src="calendar.js"></script>
    <script src="scheduler.js"></script>
    <script>
    var scheduler = createScheduler(document.body);
    </script>
    </body>
</html>
