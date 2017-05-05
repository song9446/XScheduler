<?php
session_start();
include ( "./inc/connect.inc.php" );
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
                <?php
                    if (isset($_SESSION['u_id'])){
                        echo "<a href='friends/index.php' font-size: 20px> Friend </a>";
                    }
                ?>
            </div>

            <div id="content">
                <?php
                    if (isset($_SESSION['u_id'])) {
                        echo "<p>Logged in as ". $_SESSION['u_id'] . "</p>";
                    }
                    echo "<a href='scheduler/index.php' font-size: 20px> Calendar <-- Song's Beautiful Calendar\n </a>";
                ?>
                <div id="description">
                  UniScheduler<br/>
                  This is Database lecture project.<br/>
                  Contributor : Jason Kim, Eunchul Song, Dongju Shin
                </div>
            </div>
        </div>
    </body>
</html>
