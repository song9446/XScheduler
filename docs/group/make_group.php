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
        <style>
        .container select {
          width: 300px;
          height: 600px;
          margin-left: 150px;
          margin-top: 100px;
          float: left;
        }
        </style>
    </head>

    <body>

        <?php include ( "../headerMenu.php" ); ?>

        <?php
            if ( isset($_SESSION['u_id']) ) {
                $curr_id = $_SESSION['u_id'];


                echo "<form action='create_group.php' method='post'>";
                echo "<div class='textbox'>";
                echo "<label for='group_name'>Group name: </label>";
                echo "<input type='text' name='group_name' placeholder='Enter group name' />";
                echo "</div>";

                echo "<div class='container'>";

                $query = "SELECT f_u_id FROM friend WHERE u_id = '$curr_id'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "<select name='group_members[]' size='10' multiple>";
                    while ( $row = mysqli_fetch_assoc($result) ){
                        echo "<option value='" . $row['f_u_id'] . "'>" . $row['f_u_id'] . "</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' id='btn-submit' name='submit_group' value='Submit' />";
                }

                else {
                    cout << "Error: Failed to get friend data!";
                }

                echo "</div>";
                echo "</form>";
            }

            else {
                echo "Error: You are currently NOT logged in - Invalid Approach!";
            }
        ?> 
    </body>
</html>
