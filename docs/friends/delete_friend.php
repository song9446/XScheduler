<?php
session_start();
include ( "../inc/connect.inc.php" );


if ( isset($_SESSION['u_id']) )
{
     if( isset($_GET['delete_f_u_id']) ) {
         $curr_u_id=$_SESSION['u_id']; // current u_id
         $delete_u_id=$_GET['delete_f_u_id']; // target id of delete friend

         $query1 = "DELETE FROM friend WHERE u_id = '$curr_u_id' AND f_u_id = '$delete_u_id'";
         $result1 = mysqli_query($conn, $query);

         $query2 = "DELETE FROM friend WHERE u_id = '$delete_u_id' AND f_u_id = '$curr_u_id'";
         $result2 = mysqli_query($conn, $query);

         if ($result1 && $result2) {
            echo "Successfully deleted.";
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
         }
         else if(!$result1) {
             echo "Deletion 1 failed!";
         }
         else if(!$result2) {
             echo "Deletion 2 failed!";
         }
         else {
             echo "both failed";
         }
     }
}

else{
    echo "Blocked! Not logged in!";
}

?>
