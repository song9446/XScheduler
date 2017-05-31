<?php
session_start();
include ( "../inc/connect.inc.php" );
?>


<!DOCTYPE html>
<html>
    <head>
        <title>UniScheduler</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>

    <body>
        <?php
        
            if ( isset($_SESSION['u_id']) ) {
                $curr_id = $_SESSION['u_id'];

                $query = "SELECT f_u_id FROM friend WHERE u_id = '$curr_id'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "<form action='#' method='post'>";
                    echo "<select name='group_members[]' multiple>";
                    while ( $row = mysqli_fetch_assoc($result) ){
                        echo "<option value='" . $row['f_u_id'] . "'>" . $row['f_u_id'] . "</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' name='submit_group_members' value='get_selected_values' />";
                    echo "</form>";
                }

                else {
                    cout << "Error: Failed to get friend data!";
                }
/*
                if ( isset($_POST['submit_group_members']) ) {
                    foreach ($_POST['group_members'] as member)
                    {
                        echo "You have selected :" . $member;
                    }
                }*/
            }

            else {
                cout << "Error: You are currently NOT logged in - Invalid Approach!";
            }
        ?> 
    </body>
</html>
