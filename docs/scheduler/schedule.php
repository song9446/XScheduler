<?php
session_start();
include ( "../inc/connect.inc.php" );
?>

<?php
$token = $_SESSION['u_id'];

$op = $_GET['op'];
$date_format = "%Y%m%d%H%i%s";
$query = "";

if(strcmp($op, "get_candidate") == 0){
    $g_id = $_GET['g_id'];
    $query = <<<QUERY
        SELECT p.s_id FROM p_schedule AS p, group_have_schedule AS ghs WHERE p.s_id=ghs.s_id AND ghs.g_id=$g_id GROUP BY p.s_name HAVING COUNT(g.s_id)>1;
QUERY;
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
else if(strcmp($op, "get_group_schedule_in_range") == 0){
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $g_id = $_GET['g_id'];
    $query = <<<QUERY
        SELECT p.s_id, s_name, DATE_FORMAT(start_time, '$date_format') AS start_time, DATE_FORMAT(end_time, '$date_format') AS end_time 
}
else if(strcmp($op, "get_schedule") == 0){
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
else if(strcmp($op, "get_group_schedule_in_range") == 0){
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $g_id = $_GET['g_id'];
    $query = <<<QUERY
        SELECT p.s_id, s_name, DATE_FORMAT(start_time, '$date_format') AS start_time, DATE_FORMAT(end_time, '$date_format') AS end_time 
        FROM p_schedule AS p
        WHERE (p.s_id IN (SELECT ghs.s_id FROM group_have_schedule AS ghs WHERE ghs.g_id=$g_id) OR
              p.s_id IN (SELECT p2.s_id FROM p_schedule AS p2 WHERE p2.u_id IN (SELECT gm.u_id FROM group_member AS gm WHERE gm.g_id=$g_id))) AND
              ((p.end_time >= STR_TO_DATE('$start_time', '$date_format') AND p.end_time <= STR_TO_DATE('$end_time', '$date_format')) OR
              (p.start_time >= STR_TO_DATE('$start_time', '$date_format') AND p.start_time <= STR_TO_DATE('$end_time', '$date_format'))); 
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
        FROM p_schedule AS p
        WHERE p.u_id='$token' AND
              ((p.end_time >= STR_TO_DATE('$start_time', '$date_format') AND p.end_time <= STR_TO_DATE('$end_time', '$date_format')) OR
              (p.start_time >= STR_TO_DATE('$start_time', '$date_format') AND p.start_time <= STR_TO_DATE('$end_time', '$date_format'))); 
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
    $u_id = $token
    if(isset($_GET['g_id']))
        $u_id='Null'
    $query = <<<QUERY
        INSERT INTO p_schedule (s_name, start_time, end_time, u_id, description) 
        VALUES ('$s_name', STR_TO_DATE('$start_time', '$date_format'), STR_TO_DATE('$end_time', '$date_format'), '$u_id', '$description'); 
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
    $s_id = mysqli_insert_id($conn);
    if(isset($_GET['g_id'])){
    $g_id = $_GET['g_id'];
    $query = <<<QUERY
        INSERT INTO group_have_schedule (g_id, s_id)
        VALUES ($g_id, $s_id);
QUERY;
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo '{"error":"'.mysqli_error($conn).'"}';
        echo mysqli_error($conn);
        mysqli_close($conn);
        die();
    }
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
?>
