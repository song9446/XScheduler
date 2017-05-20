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

        <?php

            echo "<h2>Friend List: </h2>";

            $curr_u_id = $_SESSION['u_id'];
            $query = "SELECT * FROM friend WHERE u_id = '$curr_u_id'";
            $result = mysqli_query($conn, $query);
            echo ("<table>");
            $first_row = true;
    
            while ($row = mysqli_fetch_assoc ($result)) {
                if ($first_row) {
                    $first_row = false;
                    // OUTput header row from keys.
                    echo '<tr>';
                    foreach ($row as $key => $field) {
                        echo '<th>' . htmlspecialchars($key) . '</th>';
                    }
                    echo '</tr>';
                }

                echo '<tr>';
                foreach($row as $key => $field) {
                    echo '<td>' . htmlspecialchars($field) . '</td>';
                }
                echo '</tr>';
            }
            echo ("</table>");
        ?>


        <form action="index.php" method="POST">
            <input type="text" name="search_u_id" size"25" placeholder="Search ID" />
            <input type="submit" name="search" value="Search" />
        </form>


        <?php
            $curr_u_id = $_SESSION['u_id'];
            $curr_search_u_id = $_POST['search_u_id'];

            //echo "$curr_u_id  $curr_search_u_id";

            if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                echo "<h2>Search Result: </h2>";

                $search_u_id = $_POST['search_u_id'];
                $query = "SELECT u_id FROM user U, friend_request FU  WHERE U.u_id = '$search_u_id' AND FU.u_id_to <> '$search_u_id'";
                $result = mysqli_query($conn, $query);

                echo ("<table>");
                echo '<tr>';
                while ( $row = mysqli_fetch_assoc($result) ){
                    echo "<td>" . "<a href='add_friend.php?add_friend_u_id=" . $row['u_id'] . "' >ADD" . "</a>" . "</td>";

                    foreach ($row as $key => $field) {
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                    }
                }
                echo '</tr>';
                echo ("</table>");
            }
        ?>

        <?php

        ?>            



    </body>



</html>

