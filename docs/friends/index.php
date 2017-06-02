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
                if($result) {
                  echo "<div class='list_elem'>";
                  echo "<div class='elem_id'>" . $row['u_id'] . "</div>";
                  echo "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>";
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
                    echo "<a id='Accept' href='accept_request.php?request_u_id=" . $row['u_id_from'] . "' >Accept" . "</a>";
                    echo "<a href='reject_request.php?request_u_id=" . $row['u_id_from'] . "' >Reject" . "</a>";
                    echo "</div>";
                    // echo "<a href='accept_request.php?request_u_id=" . $row['u_id_from'] . "' >ADD" . "</a>";
                  }
                }
              } 
            ?>
            </div>
          </div>

          <div class="friends">
            <div id="my_friends">Friends list</div>
            <div class='friend_list'>
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
            </div>
          </div>
        </div>
    </body>
</html>

