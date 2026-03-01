<?php
include "config/database.php"; 
header('Content-Type: application/json'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fullname = $conn->real_escape_string($_POST['fullname'] ?? '');
$course   = $conn->real_escape_string($_POST['course'] ?? '');
$year     = $conn->real_escape_string($_POST['year'] ?? '');
$regno    = $conn->real_escape_string($_POST['regno'] ?? '');

// check duplicate
$check = $conn->query("SELECT * FROM students WHERE reg_number='$regno'");
if($check->num_rows > 0){
    echo json_encode(['status'=>'warning','message'=>'Student Already Registered!']);
    exit();
}

// insert
$sql = "INSERT INTO students (full_name, course, year_of_study, reg_number) 
        VALUES ('$fullname','$course','$year','$regno')";

if($conn->query($sql)){
    echo json_encode(['status'=>'success','message'=>'Successfully Registered!','regno'=>$regno]);
} else {
    echo json_encode(['status'=>'danger','message'=>'Registration Failed: '.$conn->error]);
}