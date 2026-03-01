<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    echo json_encode(['status'=>'danger','message'=>'Unauthorized']); 
    exit();
}
include "../config/database.php";

$action = $_REQUEST['action'] ?? '';
$session_id = $_REQUEST['session_id'] ?? 0;

if($action == 'list'){
    $stmt = $conn->prepare("SELECT a.reg_number, s.full_name as student_name, a.scan_time
                            FROM attendance a
                            LEFT JOIN students s ON a.reg_number = s.reg_number
                            WHERE a.session_id = ?
                            ORDER BY a.scan_time DESC");
    $stmt->bind_param("i",$session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
    exit();
}

if($action == 'mark'){
    $reg_number = $_POST['reg_number'] ?? '';

    // Check if student exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE reg_number=?");
    $stmt->bind_param("s",$reg_number);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();

    if(!$student){
        echo json_encode(['status'=>'danger','message'=>'Student not found']);
        exit();
    }

    // Check if already marked
    $stmt = $conn->prepare("SELECT id FROM attendance WHERE session_id=? AND reg_number=?");
    $stmt->bind_param("is",$session_id,$reg_number);
    $stmt->execute();
    $already = $stmt->get_result()->fetch_assoc();

    if($already){
        echo json_encode(['status'=>'warning','message'=>'Attendance already marked']);
        exit();
    }

    // Insert attendance
    $stmt = $conn->prepare("INSERT INTO attendance (session_id, reg_number) VALUES (?,?)");
    $stmt->bind_param("is",$session_id,$reg_number);
    $stmt->execute();

    echo json_encode(['status'=>'success','message'=>"Attendance marked for {$student['full_name']}"]);
    exit();
}