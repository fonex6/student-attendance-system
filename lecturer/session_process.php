<?php
include "../config/database.php";

// make sure errors show while testing
ini_set('display_errors',1);
error_reporting(E_ALL);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* ---------------------------
   1. Create session
---------------------------- */
if($action==='create'){
    $subject = $conn->real_escape_string($_POST['subject'] ?? '');
    $course  = $conn->real_escape_string($_POST['course'] ?? '');
    $year    = $conn->real_escape_string($_POST['year'] ?? '');
    $date    = date("Y-m-d");

    $sql = "INSERT INTO sessions (subject, course, year_of_study, session_date)
            VALUES ('$subject','$course','$year','$date')";

    if($conn->query($sql)){
        $session_id = $conn->insert_id;
        echo json_encode([
            'status'=>'success',
            'message'=>'Session Started!',
            'session_id'=>$session_id
        ]);
    } else {
        echo json_encode([
            'status'=>'danger',
            'message'=>'Failed to start session: '.$conn->error
        ]);
    }
    exit();
}

/* ---------------------------
   2. Scan student QR
---------------------------- */
if($action==='scan'){
    $session_id = $_POST['session_id'] ?? 0;
    $student_reg = $_POST['student_reg'] ?? '';

    // get student info
    $res = $conn->query("SELECT * FROM students WHERE reg_number='$student_reg' LIMIT 1");
    if($res->num_rows==0){
        echo json_encode(['status'=>'danger','message'=>'Student not found!']);
        exit();
    }
    $student = $res->fetch_assoc();

    // check duplicate scan
    $check = $conn->query("SELECT * FROM attendance WHERE session_id='$session_id' AND student_reg='$student_reg'");
    if($check->num_rows>0){
        echo json_encode(['status'=>'warning','message'=>'Already scanned!']);
        exit();
    }

    // insert attendance
    $conn->query("INSERT INTO attendance (session_id, student_reg, student_name) 
                 VALUES ('$session_id','$student_reg','".$student['full_name']."')");

    echo json_encode(['status'=>'success','message'=>'Attendance recorded for '.$student['full_name']]);
    exit();
}

/* ---------------------------
   3. List scanned students
---------------------------- */
if($action==='list'){
    $session_id = $_GET['session_id'] ?? 0;
    $res = $conn->query("SELECT * FROM attendance WHERE session_id='$session_id' ORDER BY scan_time DESC");
    $arr=[];
    while($row=$res->fetch_assoc()){
        $arr[]=$row;
    }
    echo json_encode($arr);
    exit();
}