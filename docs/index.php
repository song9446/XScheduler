<?php
session_start();
//include ( "./inc/connect.inc.php" );
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UniScheduler</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css" />
    </head>
    <body>
        <?php include ( "./headerMenu.php" ); ?>

        <div id="inner">
            <div id="sidebar">
                <span>Test-sidebar</span>
            </div>
            <div id="content">
                <span>Test-content</span>
            </div>
        </div>

        <script src="./js/script1.js"></script>
    </body>
</html>

<?php
    echo "<meta http-equiv='refresh' content='0;url=home.php'>";
?>
