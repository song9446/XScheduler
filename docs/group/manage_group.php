<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<!DOCTYPE html>
<html>
  <head>
    <title>UniScheduler</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/group_sche_create.css" />
    <link rel="stylesheet" type="text/css" href="../css/friend.css" />
  </head>

  <body>
    <?php include ( "../headerMenu.php" ); ?>
    <div class='info'>
      <div class='group_name'>
      <?php
        $curr_u_id = $_SESSION['u_id'];
        $curr_g_id = $_GET['g_id'];

        $query = "SELECT g_name, g_creator, pic_name, pic_main
                  FROM groups
                  WHERE g_id = '$curr_g_id'";

        $result = mysqli_query($conn, $query);

        if ($result){
            $row = mysqli_fetch_assoc($result);
            echo "<div class=group_creator>";
            echo "Group creator: " . $row['g_creator'];
            echo "</div>";
            echo "<form action='#' method='post'>";
            echo "    <div class='textbox'>";
            echo "        <label for='group_name'>Group name: </label>";
            echo "        <input type='text' name='group_name' placeholder='" . $row['g_name'] . "'/>";
            echo "        <input type='submit' name='group_name_submit' id='btn-submit' value='Change' />";
            echo "    </div>";
            echo "</form>";

            if ( isset($_POST['group_name_submit']) ){
                $gn = $_POST['group_name']; // group name
                $query_update_GN = "UPDATE groups
                                    SET g_name = '$gn'
                                    WHERE g_id = '$curr_g_id'";
                $result_update_GN = mysqli_query($conn, $query_update_GN);

                echo "<meta http-equiv='refresh' content='0;url=manage_group.php?g_id=" . $curr_g_id . "'>";
            }
      ?>
      </div>

      <div class='upload_logo'>
      <?php
            echo "<form method='post' enctype='multipart/form-data'>";
            echo "<br />";
            echo "    <input type='file' name='image' />";
            echo "    <input type='submit' name='image_submit' value='Upload' />";
            echo "</form>";

            // image update function
            function saveimage($name,$image,$conn,$curr_g_id) {
                $query_update_image="UPDATE groups 
                                     SET pic_name='$name', pic_main='$image' 
                                     WHERE g_id='$curr_g_id'";

                $result_update_image=mysqli_query($conn, $query_update_image);
                if($result_update_image) {
                    echo "<br/>Image uploaded.";
                }
                else {
                    echo "<br/>Image not uploaded.";
                }
            }

            if ( isset($_POST['image_submit']) ){
                if(getimagesize($_FILES['image']['tmp_name']) == FALSE)
                {
                    echo "Please select an image.";
                }
                else
                {
                    $image= addslashes($_FILES['image']['tmp_name']);
                    $name= addslashes($_FILES['image']['name']);
                    $image= file_get_contents($image);
                    $image= base64_encode($image);
                    saveimage($name,$image,$conn,$curr_g_id);
                }
            }
        }

        else {
            echo "Failed to get group info. g_id: " . $curr_g_id;
        }
      ?>
      </div>
    </div>
    <div id='creator'>
    <?php
      echo "Group creator: " . $row['g_creator'];
    ?>
    </div>
    <div class='member_list'>
        <p> Member list </p>
        <div class='list'>
            <?php
                $curr_g_id = $_GET['g_id'];
                $query = "SELECT u_id FROM group_member WHERE g_id = '$curr_g_id'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div>";
                    echo "    <div>" . $row['u_id'] . "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>

  </body>
</html>
