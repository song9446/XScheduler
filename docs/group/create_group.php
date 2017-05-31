<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<?php
    if ( isset($_SESSION['u_id']) && isset($_POST['submit_group']) ){
        $curr_u_id = $_SESSION['u_id'];
        $gn = $_POST['group_name'];

        echo "curr_u_id: $curr_u_id";
        echo "gn: $gn";

        $query = "INSERT INTO groups VALUES ('', '$gn', '$curr_u_id')";
        $result = mysqli_query ($conn, $query);
        
        $g_id = $conn->insert_id; // get id of last query. In this case, get the value of auto incrementing g_id.
        echo "g_id: $g_id";
        if ($result) {
            $query = "INSERT INTO group_member (g_id, u_id) VALUES ('$g_id', '$curr_u_id')";
            $result = mysqli_query ($conn, $query); 

            foreach ($_POST['group_members'] as $member) {
                $query = "INSERT INTO group_member (g_id, u_id) VALUES ('$g_id', '$member')";
                $result = mysqli_query ($conn, $query);

                if ($result){

                }
                else {
                    echo "Error: Failed to add " . $member . " as a member.";
                }
            }

            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }

        else {
            echo "ERROR: Failed to create a group!";
        }
    }

    else {
        echo "Blocked! Wrong approach.";
    }
?>
