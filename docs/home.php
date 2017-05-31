<?php
session_start();
include ( "./inc/connect.inc.php" );

if( isset($_SESSION['u_id']) ){

}
else {
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
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
            <div id="home_content">
                <?php
                    $curr_u_id = $_SESSION['u_id'];
                    $query = "SELECT g_id, g_name, pic_main FROM groups G, group_member GM WHERE GM.u_id = '$curr_u_id' AND GM.g_id = G.g_id";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='calendar_main_container'>" . "<a href='home.php?g_id=" . $row['g_id'] . " '>" . "<img class='calendar_main_pic' src='data;base64, " , $row['pic_main'] . " '>" . "</a>" . "<p style='font-size: 16px; margin-top: 10px;' align='center';>" . $row['g_name'] . "</p>" . "</div>";
                        }
                    }


                ?>
            </div>
        </div>
    </body>



</html>
