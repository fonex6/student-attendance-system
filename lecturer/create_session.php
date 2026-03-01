<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}
include "../config/database.php";

$message = '';
$qrData = '';

if(isset($_POST['create'])){
    $subject = $_POST['subject'];
    $course  = $_POST['course'];
    $year    = $_POST['year'];
    $date    = date("Y-m-d");

    // Prepared statement for safety
    $stmt = $conn->prepare("INSERT INTO sessions (subject, course, year_of_study, session_date) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $subject, $course, $year, $date);
    $stmt->execute();

    $session_id = $stmt->insert_id;

    // QR data
    $qrData = $session_id;

    $message = "Session Created! Session ID: $session_id";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Session</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.qr-container img{
    width:100%;
    max-width:300px;
    height:auto;
}
</style>
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <div class="card bg-secondary p-4">
        <h2>Create Lecture Session</h2>
        <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Course</label>
                <input type="text" name="course" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Year of Study</label>
                <select name="year" class="form-control" required>
                    <option value="">Select Year</option>
                    <option>Year 1</option>
                    <option>Year 2</option>
                    <option>Year 3</option>
                    <option>Year 4</option>
                </select>
            </div>
            <button name="create" class="btn btn-success">Start Session</button>
        </form>

        <?php if($qrData): ?>
            <div class="mt-4">
                <h4>Session Details</h4>
                <p><strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?></p>
                <p><strong>Course:</strong> <?php echo htmlspecialchars($course); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($year); ?></p>

                <div class="qr-container mt-3">
                    <h5>Session QR Code:</h5>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $qrData; ?>">
                    <p class="mt-2">Session ID: <?php echo $qrData; ?></p>
                    <a href="mark_attendance.php?session_id=<?php echo $qrData; ?>" class="btn btn-primary mt-2">Go to Mark Attendance</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>