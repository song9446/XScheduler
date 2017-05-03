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
                        echo "HI";
                    }
                ?>
            </div>

            <div id="content">
                <?php
                    if (isset($_SESSION['u_id'])) {
                        echo "<p>Logged in as ". $_SESSION['u_id'] . "</p>";
                    }
<<<<<<< HEAD
                    echo "<a href='prev_index.php' font-size: 20px> Calendar <-- Song's Beautiful Calendar\n </a>";
                    echo "<a >Login is currently NOT working because it is not connected to our database.</a>";
                    echo "<a >Previous 'index.php' has been moved to 'prev_index.php'.\n</a>";
=======
                    echo "<a href='scheduler/index.php' font-size: 20px> Calendar <-- Song's Beautiful Calendar\n </a>";
                    echo "<a >Login is currently NOT working because it is not connected to our database.</a>";
>>>>>>> 15f61c3456fc86acec784261f59e8235c2e49957
                ?>
            </div>
        </div>

        <script src="./js/script1.js"></script>
    </body>
</html>
