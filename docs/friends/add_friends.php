<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UniScheduler</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>

    <body>
        <?php include ( "../headerMenu.php" ); ?>

        <form action="add_friend.php" method="POST">
            <input type="text" name="search_u_id" size"25" placeholder="Search ID" />
            <input type="submit" name="search" value="Search" />
        </form>

        <?php
            if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                echo "hi";
            }
        ?>
                

    </body>
</html>

