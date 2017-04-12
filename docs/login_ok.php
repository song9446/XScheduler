<?php
session_start();
include ( "./inc/connect.inc.php" );
?>

<?php
// User Login Code
if (isset($_POST["user_id_login"] && isset($_POST["password_login"])) {
    $user_id_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_id_login"]); // filters everything except numbers and letters
    $password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]);

    $sql = ("SELECT id FROM users WHERE u_id='$user_id_login' AND password='$paassword_login'  LIMIT 1"); // selects username = user in db and password = to password in db if one returned code continues

    // Check for their existance
    $runCount = mysqli_query($conn, $sql) or die("Error: ".mysqli_error($sql));
    $userCount = mysqli_num_rows($runCount); // Count the number of rows returned

    if ($userCount == 1) {
        while ($row = mysqli_fetch_array($runCount)){
            $id = $row["id"];
        }

        $_SESSION['u_id'] = $u_id_login;
        
        echo "<meta http-equiv='refresh' content='0;url=home.php'>";
        exit();
    }
    else {
        echo 'That information is incorrect, try again';
        exit();
    }
}

?>
