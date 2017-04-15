<?php
session_start();
include ( "./inc/connect.inc.php" );
?>

<?php
$reg = @$_POST['reg'];

//declaring variables to prevent errors
$uid = "";
$pswd = "";

//registration form
$uid = strip_tags(@$_POST['u_id_register']);
$pswd = strip_tags(@$_POST['password_register']);

echo "!";
if ($reg) {
echo "$uid  $pswd";
    if ($uid && $pswd) {
        if (strlen($uid) > 25) {
            echo "The maximum length of user id is 25 characters!";
        }

        else {
echo "!!";
            if (strlen($pswd)>30 || strlen($pswd)<5) {
                echo "Your password must be between 5 and 30 characters long!";
            }

            else {
echo "!!!";
                $query = mysqli_query($conn, "INSERT INTO user VALUES ('$uid', '$pswd')");
                echo "<h2><a href='index.php'>Welcome to UniScheduler</a></h2>";

            }
        }
    }
    else {
        echo "Please fill in all of the fields.";
    }
}

?>
