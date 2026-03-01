<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}
include "../config/database.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>All Sessions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

<h3>All Lecture Sessions</h3>

<table class="table table-bordered table-striped">
<tr>
<th>ID</th>
<th>Subject</th>
<th>Course</th>
<th>Year</th>
<th>Date</th>
<th>View Attendance</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM sessions ORDER BY id DESC");
while($row=$res->fetch_assoc()):
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['subject']; ?></td>
<td><?php echo $row['course']; ?></td>
<td><?php echo $row['year_of_study']; ?></td>
<td><?php echo $row['session_date']; ?></td>
<td>
<a href="view_attendance.php?session_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
View
</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<a href="../lecturer/dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>