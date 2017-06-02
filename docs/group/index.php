<!DOCTYPE html>
<html>
  <head>
    <title>UniScheduler</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/group_sche_create.css" />
  </head>

  <body>
    <?php include ( "../headerMenu.php" ); ?>

    <?php
        $curr_u_id = $_SESSION['u_id'];
/*
        $query = "SELECT G.g_id, G.g_name, G.g_creator, G.pic_main, MY_G_WITH_COUNT.member_num
                  FROM groups G, (SELECT g_id, COUNT(g_id) AS member_num
                                  FROM group_member 
                                  WHERE u_id = '$curr_u_id'
                                  GROUP BY g_id) AS MY_G_WITH_COUNT
                  WHERE G.g_id = MY_G_WITH_COUNT";

        $result = mysqli_query($conn, $query);
*/
        $query = "SELECT g_id, COUNT(g_id) AS member_num
                  FROM group_member
                  WHERE u_id = '$curr_u_id'
                  GROUP BY g_id";


        if ($result){
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['g_id'] . "   " . $row['member_num'];

//                echo "<div class='calendar_main_container'>" . "<a href='index.php?g_id=" . $row['g_id'] . " '>" . "<img class='calendar_main_pic' src='data;base64, " . $row['pic_main'] . " '>" . "</a>" . "</div>";
            }



        }
        else {
            echo "Error: could not get my group data.";
        }



    ?>


  </body>
</html>
