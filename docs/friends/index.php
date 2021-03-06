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
            <div class='search_list'>
              <?php
                $curr_u_id = $_SESSION['u_id'];
                $search_u_id = $_POST['search_u_id'];
                if(isset($curr_u_id) && isset($search_u_id)) {
                  $query = "SELECT u_id FROM user WHERE u_id = '$search_u_id'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                }

                $query2 = "SELECT u_id FROM friend WHERE u_id = '$curr_u_id' AND f_u_id = '$search_u_id'";
                $result2 = mysqli_query($conn, $query2);
                $row2 = mysqli_fetch_assoc($result2);
                //if($result) {
                if(isset($row) && !isset($row2)) {
                  echo "<div class='list_elem'>";
                  echo "<div class='elem_id'>" . $row['u_id'] . "</div>";
                  echo "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>";
                  echo "</div>";
                }
                else if(!isset($row) && isset($search_u_id)) {
                  echo "<div class='list_elem'>";
                  echo "<div class='elem_id'>" . "No result" . "</div>";
                  echo "</div>";
                }
                else if(isset($row2)) {
                  echo "<div class='list_elem'>";
                  echo "<div class='elem_id'>" . $row['u_id'] . " is already your friend" . "</div>";
                  echo "</div>";
                }
              ?>
            </div>
          </div>

          <div class="add_friends">
            <div id="Receive">Received Requests</div>
            <div class='list'>
            <?php
              $curr_u_id = $_SESSION['u_id'];

              if(isset($_SESSION['u_id'])) {
                $query = "SELECT u_id_from FROM friend_request WHERE u_id_to = '$curr_u_id'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                  foreach($row as $key => $field) {
                    echo "<div class='list_elem'>";
                    echo "<div class='elem_id'>" . $row['u_id_from'] . "</div>";
                    echo "<a href='reject_request.php?delete_request_u_id=" . $row['u_id_from'] . "' >Reject" . "</a>";
                    echo "<a href='accept_request.php?accept_request_u_id=" . $row['u_id_from'] . "' >Accept" . "</a>";
                    echo "</div>";
                  }
                }
              } 
            ?>
            </div>
          </div>

          <div class="friends">
            <div id="my_friends">Friends list</div>
            <div class='list'>
            <?php
              $curr_u_id = $_SESSION['u_id'];
              $query = "SELECT f_u_id FROM friend WHERE u_id = '$curr_u_id'";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc ($result)) {
                  foreach($row as $key => $field) {
                      echo "<div class='list_elem'>";
                      echo "<div class='elem_id'>" . $row['f_u_id'] . "</div>";
                      echo "<a href='delete_friend.php?delete_f_u_id=" . $row['f_u_id'] . "' >Delete" . "</a>";
                      echo "</div>";
                  }
              }
            ?>
            </div>
          </div>
        </div>
    </body>
</html>

