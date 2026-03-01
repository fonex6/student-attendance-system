<?php include("../config/database.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration - Smart Attendance</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
    font-family:'Segoe UI', sans-serif;
    min-height:100vh;
}
.container-card {
    max-width:600px;
    margin-top:50px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    padding:30px;
    border-radius:20px;
}
h2{
    text-align:center;
    margin-bottom:20px;
}
img.qr-code{
    display:block;
    margin:20px auto;
}
.alert{
    text-align:center;
}
</style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="container-card">

<?php
$showQR = false;
$qrData = "";

if(isset($_POST['register'])){
    $reg = htmlspecialchars($_POST['reg']);
    $name = htmlspecialchars($_POST['name']);
    $course = htmlspecialchars($_POST['course']);
    $year = htmlspecialchars($_POST['year']);

    // Check duplicate
    $check = $conn->query("SELECT * FROM students WHERE reg_number='$reg'");
    if($check->num_rows > 0){
        echo '<div class="alert alert-warning">Student Already Registered!</div>';
    } else {
        $insert = $conn->query("INSERT INTO students (reg_number, full_name, course, year_of_study)
            VALUES ('$reg','$name','$course','$year')");
        if($insert){
            echo '<div class="alert alert-success">Successfully Registered!</div>';
            $showQR = true;
            $qrData = $reg;
        } else {
            echo '<div class="alert alert-danger">Registration Failed: '.$conn->error.'</div>';
        }
    }
}
?>

<h2>Student Registration</h2>

<form method="POST">
    <div class="mb-3">
        <label>Registration Number</label>
        <input type="text" name="reg" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" required>
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
    <button name="register" class="btn btn-success w-100">Register</button>
</form>

<?php if($showQR): ?>
    <h3 class="text-center mt-4">Your QR Code</h3>
    <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($qrData); ?>" alt="QR Code">
<?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>