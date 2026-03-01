<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}

include "../config/database.php";

// Quick statistics
$totalStudents  = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
$totalSessions  = $conn->query("SELECT COUNT(*) as total FROM sessions")->fetch_assoc()['total'];
$totalAttendance= $conn->query("SELECT COUNT(*) as total FROM attendance")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f4f6f8;font-family:'Segoe UI',sans-serif;}
.navbar{background:#212529;}
.card{margin-top:20px;border-radius:12px;}
.stat-card{color:white;border:none;}
.stat1{background:#0d6efd;}
.stat2{background:#198754;}
.stat3{background:#dc3545;}
</style>
</head>
<body>

<nav class="navbar navbar-dark px-4">
  <span class="navbar-brand">Admin Dashboard</span>
  <div class="ms-auto">
    <span class="text-white">Welcome, <?php echo $_SESSION['admin_name']; ?></span>
    <a href="logout.php" class="btn btn-danger btn-sm ms-3">Logout</a>
  </div>
</nav>

<div class="container mt-4">

  <!-- Statistics -->
  <div class="row">
    <div class="col-md-4">
      <div class="card stat-card stat1 p-4 shadow">
        <h4><?php echo $totalStudents; ?></h4>
        <p>Total Students</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card stat2 p-4 shadow">
        <h4><?php echo $totalSessions; ?></h4>
        <p>Total Sessions</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card stat3 p-4 shadow">
        <h4><?php echo $totalAttendance; ?></h4>
        <p>Total Attendance Records</p>
      </div>
    </div>
  </div>

  <!-- Main Actions -->
  <div class="row mt-4">

    <div class="col-md-6">
      <div class="card p-4 shadow">
        <h5>Start Lecture Session</h5>
        <p>Create new lecture session and generate QR code.</p>
        <a href="../lecturer/create_session.php" class="btn btn-primary">Start Session</a>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-4 shadow">
        <h5>Manage Students</h5>
        <p>Add, Edit or Delete students.</p>
        <a href="../admin/student_crud.php" class="btn btn-success">Manage Students</a>
      </div>
    </div>

  </div>

  <div class="row mt-4">

    <div class="col-md-6">
      <div class="card p-4 shadow">
        <h5>View Sessions</h5>
        <p>See all created lecture sessions.</p>
        <a href="../admin/view_sessions.php" class="btn btn-dark">View Sessions</a>
      </div>
    </div>

  <!-- <div class="col-md-6">
      <div class="card p-4 shadow">
        <h5>View Attendance Records</h5>
        <p>Check attendance by session.</p>
        <a href="../admin/view_attendance.php" class="btn btn-warning">View Attendance</a>
      </div>
    </div>-->

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>