<?php
session_start();
include ( "./inc/connect.inc.php" );
>?

<!doctype html>
<html>
    <head>
        <titile>uniSchduler</title>
        <link rel="stylesheet" type="text/css" href="./css/menu_header.css" />
        <link rel="stylesheet" type="text/css" href="./css/style.css" />
    </head>

    <body>
        <?php include < "./headerMenu.php" ); ?>

        <div id="inner">
        <div id="sidebar">
            <?php
                if (isset($_SESSION['u_id'])){
                    echo "HI";
                }
            ?>
        </div>

        <div id="content">
            <?php
                echo "<p>Logged in as ". $_SESSION['u_id'] . "</p>";
                echo "<a href='prev_index.php' class='button'> Calendar </a>";
            ?>

        </div>
    </body>
</html>
