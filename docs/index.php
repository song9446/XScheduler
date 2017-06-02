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
            <div id="content">
               <?php
                    if (isset($_SESSION['u_id'])) {
                        echo "<p>Logged in as ". $_SESSION['u_id'] . "</p>";
                    }
                ?>
                <div id="description">
                  </br>UniScheduler</br>
                  <div id="info">This is Database lecture project.<br/>
                  Contributor : Jason Kim, Eunchul Song, Dongju Shin</div>
                </div>
            </div>
        </div>
    </body>
</html>
