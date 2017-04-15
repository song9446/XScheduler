<?php
$servername = "xscheduler.c4l3nt5dolim.ap-northeast-2.rds.amazonaws.com";
$username = "root";
$password = "qwer1234";
$dbname = "UniScheduler";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die ("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully!";
?>
