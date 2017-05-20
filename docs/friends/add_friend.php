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

        if ($result){
            $query = "DELETE FROM friend request WHERE u_id_from = '$ui1' AND u_id_to = '$ui2'";
            $result = mysqli_query($conn, $query);

            if ($result){
                echo "Deleted successfully 1.";
            }

            else{
                echo "Failed to delete a friend request1!";
            }
        }


        $query = "SELECT * FROM friend_request WHERE u_id_from = '$ui2' AND u_id_to = '$ui1'";
        $result = mysqli_query($conn, $query);

        if ($result){
            $query = "DELETE FROM friend_request WHERE u_id_from = '$ui2' AND u_id_to ='$ui1'";
            $result = mysqli_query($conn, $query);

            if ($result){
                echo "Deleted successfully 2.";
            }

            else{
                echo "Failed to delete a friend request2!";
            }
        }



        $query = "INSERT INTO friend (u_id, f_u_id) VALUES ('$ui1', '$ui2')";
        $result = mysqli_query($conn, $query);

        if ($result){
            echo "<br/>Friend " . $ui2 . "has been added.";
            echo "<meta http=euiv='refresh' content='0;url=index.php'>";
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

