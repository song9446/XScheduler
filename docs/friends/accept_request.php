<?php
session_start();
include ( "../inc/connect.inc.php" );


if ( isset($_SESSION['u_id']) )
{
    if( isset($_GET['accept_request_u_id']) ){
        $ui1=$_SESSION['u_id']; // u_id 1
        $ui2=$_GET['accept_request_u_id']; // u_id 2


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


        $query3 = "INSERT INTO friend (u_id, f_u_id) VALUES ('$ui1', '$ui2')";
        $result3 = mysqli_query($conn, $query3);

        $query4 = "INSERT INTO friend (u_id, f_u_id) VALUES ('$ui2', '$ui1')";
        $result4 = mysqli_query($conn, $query4);

        if ($result3 && $result4){
            echo "<br/>Friend " . $ui2 . " has been added.";
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }

        else {
            echo "<br/>Error, could not add a friend.";
        }
    }
}


else{
        echo "Blocked! Not logged in!";
}

?>

