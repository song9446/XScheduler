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
    <?php include ( "../headerMenu.php" ); ?>
        echo "<h2>Friend List: </h2>";

        $query = "SELECT * FROM friend WHERE u_id = $_SESSION['u_id']";
        $result = mysqli_query($conn, $query);
        echo ("<table>");
        $firest_row = true;

        while ($row = mysqli_fetch_assoc ($result)) {
            if ($first_row) {
                $first_row = false;
                // OUTput header row from keys.
                echo '<tr>';
                foreach ($row as $key => $field) {
                    echo '<th>' . htmlspecialchars($key) . '</th>';
                }
                echo '</tr>';
            }

            echo '<tr>';
            foreach($row as $key => $field) {
                echo '<td>' . htmlspecialchars($field) . '</td>';
            }
            echo '</tr>';
        }
        echo ("</table>");



        <form action="add_friend.php" method="POST">
            <input type="text" name="search_u_id" size"25" placeholder="Search ID" />
            <input type="submit" name="search" value="Search" />
        </form>


        <?php
            if ( isset($_SESSION['u_id']) && isset($_POST['search_u_id']) ) {
                
            }
        ?>


    </body>



</html>

