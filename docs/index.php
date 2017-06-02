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
                        echo "<meta http-equiv='refresh' content='0;url=http://52.78.81.68/home.php'>";
                    }
                ?>
                <div id="description">
                  </br>UniScheduler</br>
                  <div id="info">This is a Database Course Term Project.<br/>
                  Contributors : Jason Kim, Eunchul Song, Dongju Shin</div>
                </div>
            </div>
        </div>
    </body>
</html>
