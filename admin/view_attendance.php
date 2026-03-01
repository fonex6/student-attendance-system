<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}
include "../config/database.php";

$session_id = $_GET['session_id'] ?? 0;

// Get session details
$stmt = $conn->prepare("SELECT * FROM sessions WHERE id = ?");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$session = $stmt->get_result()->fetch_assoc();

// Fetch attendance records with student names
$stmt2 = $conn->prepare("
    SELECT a.reg_number, s.full_name AS student_name, a.scan_time
    FROM attendance a
    LEFT JOIN students s ON a.reg_number = s.reg_number
    WHERE a.session_id = ?
    ORDER BY a.scan_time DESC
");
$stmt2->bind_param("i", $session_id);
$stmt2->execute();
$res = $stmt2->get_result();
?>





<!DOCTYPE html>
<html>
<head>
<title>Attendance Records</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f8f9fa; }
.card { margin-top: 30px; padding: 20px; }
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <h3>Attendance Records</h3>

        <?php if($session): ?>
            <p><strong>Subject:</strong> <?php echo htmlspecialchars($session['subject']); ?></p>
            <p><strong>Course:</strong> <?php echo htmlspecialchars($session['course']); ?></p>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($session['year_of_study']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($session['session_date']); ?></p>
        <?php endif; ?>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Reg No</th>
                    <th>Student Name</th>
                    <th>Scan Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['reg_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['scan_time']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

<a href="../lecturer/download_attendance.php?session_id=<?php echo $session_id; ?>" 
   class="btn btn-primary btn-sm mt-2">
   Download Attendance PDF
</a>


        <a href="../lecturer/dashboard.php" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
</body>
</html>