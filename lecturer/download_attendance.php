<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}

include "../config/database.php";

// Include FPDF
require_once __DIR__ . "/../fpdf/fpdf.php";

$session_id = $_GET['session_id'] ?? 0;

// Fetch session details
$stmt = $conn->prepare("SELECT * FROM sessions WHERE id=?");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$session = $stmt->get_result()->fetch_assoc();

// Fetch attendance records
$stmt2 = $conn->prepare("
    SELECT a.reg_number, s.full_name AS student_name, a.scan_time
    FROM attendance a
    LEFT JOIN students s ON a.reg_number = s.reg_number
    WHERE a.session_id=?
    ORDER BY a.scan_time ASC
");
$stmt2->bind_param("i", $session_id);
$stmt2->execute();
$attendance = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Attendance Records',0,1,'C');

// Session details
$pdf->SetFont('Arial','',12);
$pdf->Ln(2);
$pdf->Cell(0,6,"Subject: " . ($session['subject'] ?? ''),0,1);
$pdf->Cell(0,6,"Course: " . ($session['course'] ?? ''),0,1);
$pdf->Cell(0,6,"Year: " . ($session['year_of_study'] ?? ''),0,1);
$pdf->Cell(0,6,"Date: " . ($session['session_date'] ?? ''),0,1);
$pdf->Ln(4);

// Table header
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,7,"Reg Number",1);
$pdf->Cell(80,7,"Student Name",1);
$pdf->Cell(50,7,"Scan Time",1);
$pdf->Ln();

// Table rows
$pdf->SetFont('Arial','',12);
foreach($attendance as $row){
    $pdf->Cell(40,6,$row['reg_number'],1);
    $pdf->Cell(80,6,$row['student_name'],1);
    $pdf->Cell(50,6,$row['scan_time'],1);
    $pdf->Ln();
}

// Output PDF and force download
$pdf->Output("D","attendance_session_{$session_id}.pdf");
exit;