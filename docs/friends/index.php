<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UniScheduler</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/friends.css"/>
    </head>




    <body>
        <?php include ( "../headerMenu.php" ); ?>

        <div class='container'>
          <div class='get_friends'>
            <div id="Send">Send Request</div>
            <form action="index.php" method="POST">
              <input type="text" name="search_u_id" size"25" placeholder="Search ID" />
              <input type="submit" name="search" value="Search" />
            </form>
            <?php
              $curr_u_id = $_SESSION['u_id'];
              $curr_search_u_id = $_POST['search_u_id'];

              echo ("<table>");
              if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                $search_u_id = $_POST['search_u_id'];
                $query = "SELECT u_id FROM user WHERE u_id = '$search_u_id'";
                $result = mysqli_query($conn, $query);
                while ( $row = mysqli_fetch_assoc($result) ){
                  echo "<tr height='23'>";
                    foreach ($row as $key => $field) {
                      echo "<td>" . htmlspecialchars($field) . '</td>';
                    }
                    echo "<td>" . "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>" . "</td>";
                  echo '</tr>';
                }
              }
              echo ("</table>");
            ?>

          </div>
          <div class="add_friends">
            <div id="Receive">Received Requests</div>
            <select size='100'>

            </select>
          </div>
          <div class="friends">
            <div id="my_friends">Friends list</div>
            <select size='100'>
            <?php
              echo "<h2>Friend List: </h2>";

              $curr_u_id = $_SESSION['u_id'];
              $query = "SELECT f_u_id FROM friend WHERE u_id = '$curr_u_id'";
              $result = mysqli_query($conn, $query);

              $count = 1;
              while ($row = mysqli_fetch_assoc ($result)) {
                  foreach($row as $key => $field) {
                      echo '<option value="' . $count . '">' . htmlspecialchars($field) . '</option>';
                  }
                  $count = $count+1;
              }
            ?>
            </select>
          </div>
        </div>

       <?php
        /*
            $curr_u_id = $_SESSION['u_id'];
            $curr_search_u_id = $_POST['search_u_id'];

            //echo "$curr_u_id  $curr_search_u_id";

            if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                echo "<h2>Search Result: </h2>";

                $search_u_id = $_POST['search_u_id'];
                $query = "SELECT u_id FROM user WHERE u_id = '$search_u_id'";
                $result = mysqli_query($conn, $query);

                echo ("<table>");
                while ( $row = mysqli_fetch_assoc($result) ){
                    echo '<tr>';
                    echo "<td>" . "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>" . "</td>";

                    foreach ($row as $key => $field) {
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                    }

                    echo '</tr>';
                }
                echo ("</table>");
            }
            */
        ?>       <?php
        /*
            $curr_u_id = $_SESSION['u_id'];
            $curr_search_u_id = $_POST['search_u_id'];

            //echo "$curr_u_id  $curr_search_u_id";

            if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                echo "<h2>Search Result: </h2>";

                $search_u_id = $_POST['search_u_id'];
                $query = "SELECT u_id FROM user WHERE u_id = '$search_u_id'";
                $result = mysqli_query($conn, $query);

                echo ("<table>");
                while ( $row = mysqli_fetch_assoc($result) ){
                    echo '<tr>';
                    echo "<td>" . "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>" . "</td>";

                    foreach ($row as $key => $field) {
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                    }

                    echo '</tr>';
                }
                echo ("</table>");
            }
            */
        ?>

        <?php
            $curr_u_id = $_SESSION['u_id'];
            
            if ( isset($_SESSION['u_id']) ){
                echo "<h2>Friend Requests: </h2>";

                $query = "SELECT u_id_from FROM friend_request WHERE u_id_to = '$curr_u_id'";
                $result = mysqli_query($conn, $query);

                echo ("<table>");
                while ( $row = mysqli_fetch_assoc($result) ){
                    echo '<tr>';

                    echo "<td>" . "<a href='add_friend.php?add_friend_u_id=" . $row['u_id_from'] . "' >ADD" . "</a>" . "</td>";
                    foreach ($row as $key => $field) {
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                    }
                    echo '</tr>';
                }
                echo ("</table>");


            }
        ?>            



    </body>



</html>

