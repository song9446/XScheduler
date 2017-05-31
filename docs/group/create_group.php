<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<?php
    if ( isset($_SESSION['u_id']) && isset($_POST['submit_group']) ){
        $curr_u_id = $_SESSION['u_id'];
        $gn = $_POST['group_name'];

        $query = "INSERT INTO group (g_id, g_name, g_creator) VALUES ('', '$gn', '$curr_u_id')";
        $result = mysqli_query ($conn, $query);
        
        $g_id = mysqli_insert_id();
        echo "g_id: $g_id";
        if ($result) {
            foreach ($_POST['group_members'] as $member) {
                $query = "INSERT INTO group_member (g_id, u_id) VALUES ('$g_id', '$member')";
                $result = mysqli_query ($conn, $query);

                if ($result){
                    echo "meta http-equiv='refresh' content='0;url=index.php'>";
                }
                else {
                    echo "Error: Failed to add " . $member . " as a member.";
                }
            }
        }

        else {
            echo "ERROR: Failed to create a group!";
        }
    }

    else {
        echo "Blocked! Wrong approach.";
    }
?>
