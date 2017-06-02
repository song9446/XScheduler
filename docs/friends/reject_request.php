<?php
session_start();
include ( "../inc/connect.inc.php" );

if ( isset($_SESSION['u_id']) )
{
    if( isset($_GET['add_friend_u_id']) ){
        $ui1=$_SESSION['u_id']; // u_id 1
        $ui2=$_GET['add_friend_u_id']; // u_id 2


        $query = "SELECT * FROM friend_request WHERE u_id_from = '$ui1' AND u_id_to = '$ui2'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0){
            $query_2 = "DELETE FROM friend request WHERE u_id_from = '$ui1' AND u_id_to = '$ui2'";
            $result_2 = mysqli_query($conn, $query_2);

            if ($result_2){
                echo "Deleted successfully 1.";
            }

            else{
                echo "Failed to delete a friend request1!";
            }
        }

        $query2 = "SELECT * FROM friend_request WHERE u_id_from = '$ui2' AND u_id_to = '$ui1'";
        $result2 = mysqli_query($conn, $query2);
        $count2 = mysqli_num_rows($result2);

        if ($count2 > 0){
            $query2_2 = "DELETE FROM friend_request WHERE u_id_from = '$ui2' AND u_id_to ='$ui1'";
            $result2_2 = mysqli_query($conn, $query2_2);

            if ($result2_2){
                echo "Deleted successfully 2.";
            }

            else{
                echo "Failed to delete a friend request2!";
            }
        }
        echo "<br/>Request rejected";
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    }
}

