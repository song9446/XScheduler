<?php
$token = "asdf";
$conn = mysqli_connect(
    "xscheduler.c4l3nt5dolim.ap-northeast-2.rds.amazonaws.com",
    "root",
    "qwer1234",
    "XScheduler"
    );

if(mysqli_connect_errno()) {
    echo mysqli_connect_error();
    die();
}

$op = $_GET['op'];
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
$date_format = "%Y%m%d%H%i%s";
$query = "";

if(strcmp($op, "get_schedule") == 0){
    $query = <<<QUERY
        SELECT s_id, s_name, DATE_FORMAT(start_time, '$date_format') AS start_time, DATE_FORMAT(end_time, '$date_format') AS end_time 
        FROM p_schedule 
        WHERE u_id='$token' AND
              end_time >= STR_TO_DATE('$start_time', '$date_format') AND
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
    $query = <<<QUERY
        INSERT INTO p_schedule (s_name, start_time, end_time, u_id) 
        VALUES ('$s_name', STR_TO_DATE('$start_time', '$date_format'), STR_TO_DATE('$end_time', '$date_format'), '$token'); 
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
    echo '{"success": 1}';
}

mysqli_close($conn);

?>

