<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Smart Attendance System</title>

<!-- PWA Meta -->
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#203a43">
<meta name="apple-mobile-web-app-capable" content="yes">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    font-family: 'Segoe UI', sans-serif;
    color:white;
    min-height:100vh;
    margin:0;
}
.navbar{ background: rgba(0,0,0,0.65); box-shadow:0 4px 6px rgba(0,0,0,0.3);}
.hero{height:85vh;display:flex;align-items:center;justify-content:center;text-align:center;}
.card-custom{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border:none;
    border-radius:25px;
    padding:40px;
    box-shadow:0 8px 25px rgba(0,0,0,0.5);
}
.btn-main{
    padding:14px 35px;
    border-radius:30px;
    font-weight:600;
    transition:0.3s;
}
.btn-main:hover{transform: scale(1.05);}
.clock{
    font-size:18px;
    font-weight:500;
}
.footer{
    background: rgba(0,0,0,0.65);
    padding:12px;
    text-align:center;
    font-size:12px;
    color:#ccc;
}
.modal-content{border-radius:15px;}
input:invalid{border-color:#ff6b6b;}
input:valid{border-color:#1dd1a1;}
</style>
</head>

<body>
<nav class="navbar navbar-dark px-4">
  <span class="navbar-brand fw-bold">Smart Attendance System</span>
  <div class="ms-auto clock" id="datetime"></div>
</nav>

<div class="container hero">
    <div class="col-md-8">
        <div class="card card-custom">
            <h1 class="mb-3">QR Code Based Attendance</h1>
            <p class="mb-4">
                Fast, Secure and Automated Lecture Attendance Tracking
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="btn btn-success btn-main" data-bs-toggle="modal" data-bs-target="#studentModal">
                    Student Registration
                </button>

                <button class="btn btn-warning btn-main" data-bs-toggle="modal" data-bs-target="#adminModal">
                    Admin Login
                </button>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> Smart Attendance | Developed by GELARD, GOODLUCK, GRACE & MIRIAM
</div>

<!-- ================= STUDENT MODAL ================= -->
<div class="modal fade" id="studentModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Student Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="studentForm">
          <div class="row">
            <div class="col-md-6 mb-3">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Course</label>
                <input type="text" name="course" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Year of Study</label>
                <select name="year" class="form-control" required>
                    <option value="">Select Year</option>
                    <option>Year 1</option>
                    <option>Year 2</option>
                    <option>Year 3</option>
                    <option>Year 4</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Registration Number</label>
                <input type="text" name="regno" class="form-control" id="regno" required placeholder="231005333500">
            </div>
          </div>

          <div id="regMessage"></div>
          <button type="submit" class="btn btn-success w-100">Register Now</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ================= ADMIN MODAL ================= -->
<div class="modal fade" id="adminModal">
  <div class="modal-dialog">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Admin Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
<form method="POST" action="lecturer/admin_login.php">
  <div class="mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-dark w-100">Login</button>
</form>
      </div>
    </div>
  </div>
</div>

<script>
/* LIVE DATE & TIME */
function updateDateTime(){
    const now = new Date();
    const options = {weekday:'long',year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit'};
    document.getElementById('datetime').innerHTML = now.toLocaleString('en-TZ', options);
}
setInterval(updateDateTime,1000);
updateDateTime();

/* STUDENT REGISTRATION AJAX */
const studentForm = document.getElementById("studentForm");
const regnoInput = document.getElementById("regno");

studentForm.addEventListener("submit", function(e){
    e.preventDefault();
    let regNoVal = regnoInput.value.trim();

    // Check if registration number starts with 231
    if(!regNoVal.startsWith("231")){
        alert("Registration Number must start with 231");
        regnoInput.focus();
        return;
    }

    let formData = new FormData(this);
    fetch("student_register_process.php",{method:"POST",body:formData})
    .then(res => res.json())
    .then(data => {
        console.log(data); // debug
        document.getElementById("regMessage").innerHTML = `<div class="alert alert-success">Successfully Registered!</div>`;
        setTimeout(()=>{document.getElementById("regMessage").innerHTML="";},2000);
        studentForm.reset();
    })
    .catch(err=>{
        document.getElementById("regMessage").innerHTML = '<div class="alert alert-danger">Registration Failed</div>';
    });
});



// SERVICE WORKER REGISTRATION
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('sw.js')
        .then(reg => console.log('Service Worker registered.', reg))
        .catch(err => console.log('Service Worker registration failed:', err));
    });
}



</script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>