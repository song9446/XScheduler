<?php
session_start();
include ( "../inc/connect.inc.php" );


if ( isset($_SESSION['u_id']) )
{
     if( isset($_GET['delete_friend_u_id']) ) {
         $curr_u_id=$_SESSION['u_id']; // current u_id
         $delete_u_id=$_GET['delete_friend_u_id']; // target id of delete friend

         $query = "DELETE FROM friend WHERE u_id = '$curr_u_id' AND f_u_id = '$delete_u_id'";
         $result = mysqli_query($conn, $query);

         if ($result) {
            echo "Successfully deleted.";
            //echo "<meta http-equiv='refresh' content='0;url=index.php'>";
         }
         else {
             echo "Deletion failed!"
         }
     }
}

else{
    echo "Blocked! Not logged in!";
}

?>
