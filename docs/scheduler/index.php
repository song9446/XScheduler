<?php
session_start();
include ( "./inc/connect.inc.php" );
?>

<html>
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="calendar.css"></link>
    <link rel="stylesheet" href="scheduler.css"></link>
    <link rel="stylesheet" href="timetable.css"></link>
    <title> UniScheduler </title>
    </head>
    <body>
    <?php include ( "../headerMenu.php" ); ?>
    <script src="calendar.js"></script>
    <script src="scheduler.js"></script>
    <script src="timetable.js"></script>
    <script>
    <?php
    if(isset($_GET['g_id']))
        echo "var scheduler = createScheduler(document.body,null,null,null,".$_GET['g_id'].");";
    else
        echo "var scheduler = createScheduler(document.body);";
    ?>
    </script>
    </body>
</html>
