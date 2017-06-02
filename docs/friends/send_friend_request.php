<?php
session_start();
include ( "../inc/connect.inc.php" );

  
if ( isset($_SESSION['u_id']) )
{
    if( isset($_GET['request_friend_u_id']) ){
        $uif=$_SESSION['u_id']; // u_id_from
        $uit=$_GET['request_friend_u_id']; // u_id_to

        $query = "INSERT INTO friend_request (u_id_from, u_id_to) VALUES ('$uif', '$uit')";
        $result = mysqli_query($conn, $query);

        if ($result){
            echo "<br/>Request has been sent.";
            echo "<meta http=equiv='refresh' content='0;url=index.php'>";
        }

        else {
            echo "<br/>Error, could not send a request.";
        }
    }
}

else{
    echo "Blocked! Not logged in!";
}

?>
