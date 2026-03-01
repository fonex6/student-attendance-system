<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}
include "../config/database.php";

$session_id = $_GET['session_id'] ?? 0;

// Use prepared statement to fetch session details safely
$stmt = $conn->prepare("SELECT * FROM sessions WHERE id = ?");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$session = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mark Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#1c1c1c; color:white; font-family:'Segoe UI',sans-serif; }
.card{ margin-top:30px; border-radius:15px; backdrop-filter:blur(15px); background:rgba(255,255,255,0.1); }
.alert{ position:relative; transition: opacity 0.5s ease; }
</style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h3>Lecture: <?php echo htmlspecialchars($session['subject'] ?? ''); ?></h3>
        <p>Course: <?php echo htmlspecialchars($session['course'] ?? ''); ?> | Year: <?php echo htmlspecialchars($session['year_of_study'] ?? ''); ?></p>

        <div class="mb-3">
            <label>Student Reg Number:</label>
            <input type="text" id="reg_number" class="form-control" placeholder="Enter Reg Number">
            <button id="markBtn" class="btn btn-success mt-2">Mark Attendance</button>
            <a href="../lecturer/dashboard.php" class="btn btn-secondary mt-2 ms-2">Back to Dashboard</a>
        </div>

        <div id="message"></div>

        <h5 class="mt-4">Marked Students</h5>
        <table class="table table-bordered table-striped" id="attendanceTable">
            <thead>
                <tr><th>Reg Number</th><th>Student Name</th><th>Scan Time</th></tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
const sessionId = "<?php echo $session_id; ?>";

function loadAttendance(){
    fetch('attendance_process.php?action=list&session_id='+sessionId)
    .then(res=>res.json())
    .then(data=>{
        let html='';
        data.forEach(s=>{
            html+=`<tr>
                <td>${s.reg_number}</td>
                <td>${s.student_name}</td>
                <td>${s.scan_time}</td>
            </tr>`;
        });
        document.querySelector('#attendanceTable tbody').innerHTML = html;
    });
}

document.getElementById('markBtn').addEventListener('click', ()=>{
    const reg = document.getElementById('reg_number').value.trim();
    if(!reg) return alert("Enter Registration Number");

    let formData = new FormData();
    formData.append('action','mark');
    formData.append('session_id', sessionId);
    formData.append('reg_number', reg);

    fetch('attendance_process.php',{
        method:'POST',
        body: formData
    })
    .then(res=>res.json())
    .then(data=>{
        // Show message
        const msgDiv = document.getElementById('message');
        msgDiv.innerHTML = `<div class="alert alert-${data.status}">${data.message}</div>`;

        // Auto remove after 2 seconds
        setTimeout(()=>{ msgDiv.innerHTML = ''; }, 2000);

        document.getElementById('reg_number').value='';
        loadAttendance();
    });
});

// Initial load
window.onload = loadAttendance;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>