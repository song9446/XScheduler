<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<?php
$token = $_SESSION['u_id'];

$op = $_GET['op'];
$date_format = "%Y%m%d%H%i%s";
$query = "";

if(strcmp($op, "get_schedule") == 0){
    $s_id = $_GET['s_id'];
    $query = <<<QUERY
        SELECT s_id, s_name, DATE_FORMAT(start_time, '$date_format') AS start_time, DATE_FORMAT(end_time, '$date_format') AS end_time, description
        FROM p_schedule 
        WHERE u_id='$token' AND
            s_id='$s_id';
QUERY;
    //What I really want : 
    //WHERE u_id=(SELECT u_id from user where token='$token') 
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        mysqli_close($conn);
        die();
    }

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    echo json_encode($arr);
}
else if(strcmp($op, "get_schedule_in_range") == 0){
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $query = <<<QUERY
        SELECT s_id, s_name, DATE_FORMAT(start_time, '$date_format') AS start_time, DATE_FORMAT(end_time, '$date_format') AS end_time 
        FROM p_schedule 
        WHERE u_id='$token' AND
              end_time > STR_TO_DATE('$start_time', '$date_format') AND
              start_time < STR_TO_DATE('$end_time', '$date_format'); 
QUERY;
    //What I really want : 
    //WHERE u_id=(SELECT u_id from user where token='$token') 
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        mysqli_close($conn);
        die();
    }

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    echo json_encode($arr);
}

else if(strcmp($op, "add_schedule") == 0){
    $s_name = $_GET['s_name'];
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $description = $_GET['description'];
    $query = <<<QUERY
        INSERT INTO p_schedule (s_name, start_time, end_time, u_id, description) 
        VALUES ('$s_name', STR_TO_DATE('$start_time', '$date_format'), STR_TO_DATE('$end_time', '$date_format'), '$token', '$description'); 
QUERY;
    //What I really want : 
    //WHERE u_id=(SELECT u_id from user where token='$token') 
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        echo mysqli_error($conn);
        mysqli_close($conn);
        die();
    }
    echo '{"s_id":'.mysqli_insert_id($conn).'}';
}
else if(strcmp($op, "delete_schedule") == 0){
    $s_id = $_GET['s_id'];
    $query = <<<QUERY
        DELETE FROM p_schedule 
        WHERE u_id='$token' AND s_id='$s_id';
QUERY;
    //What I really want : 
    //WHERE u_id=(SELECT u_id from user where token='$token') 
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        echo mysqli_error($conn);
        mysqli_close($conn);
        die();
    }
    echo '{"s_id":'.$s_id.'}';
}
else if(strcmp($op, "update_schedule") == 0){
    $s_id = $_GET['s_id'];
    $s_name = $_GET['s_name'];
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $description = $_GET['description'];
    $query = <<<QUERY
        UPDATE p_schedule 
        SET s_name='$s_name', start_time=STR_TO_DATE('$start_time', '$date_format'), end_time=STR_TO_DATE('$end_time', '$date_format'), description='$description' 
        WHERE u_id='$token' AND s_id='$s_id';
QUERY;
    //What I really want : 
    //WHERE u_id=(SELECT u_id from user where token='$token') 
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        echo mysqli_error($conn);
        mysqli_close($conn);
        die();
    }
    echo '{"s_id":'.$s_id.'}';
}


mysqli_close($conn);
