<?php
session_start();
include ( "./inc/connect.inc.php" );
echo $_SESSION['u_id'];
?>
