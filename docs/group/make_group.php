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

                $query = "SELECT * FROM friend WHERE u_id = '$curr_id'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo ("<table>");
                    while ( $row = mysqli_fetch_assoc($result) ){
                        echo '<tr>';
                        foreach ($row as $key => $field) {
                            echo "<td>" . htmlspecialchars($field) . '</td>';
                        }
                        echo "<td>" . "<a href='send_friend_request.php?request_friend_u_id=" . $row['u_id'] . "' >SEND" . "</a>" . "</td>";
                        echo '</tr>';
                    }
                    echo ("</table>");
                }

                else {
                    cout << "Error: Failed to get friend data!";
                }
            }

            else {
                cout << "Error: You are currently NOT logged in - Invalid Approach!";
            }
        ?> 
    </body>
</html>
