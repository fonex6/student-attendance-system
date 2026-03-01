<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../index.php");
    exit();
}

include("../config/database.php");


// ADD STUDENT
if(isset($_POST['add_student'])){

    $reg_number = $_POST['reg_number'];
    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $year_of_study = $_POST['year_of_study'];

    // Check duplicate
    $stmt = $conn->prepare("SELECT id FROM students WHERE reg_number=?");
    $stmt->bind_param("s", $reg_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $error = "Registration number already exists!";
    } else {

        $stmt = $conn->prepare("INSERT INTO students (reg_number, full_name, course, year_of_study) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $reg_number, $full_name, $course, $year_of_study);

        if($stmt->execute()){
            $success = "Student added successfully!";
        } else {
            $error = "Error adding student.";
        }
    }
}


// DELETE STUDENT (SAFE VERSION)
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: student_crud.php");
    exit();
}


// UPDATE STUDENT
if(isset($_POST['update_student'])){
    $id = $_POST['id'];
    $reg_number = $_POST['reg_number'];
    $full_name = $_POST['full_name'];
    $course = $_POST['course'];
    $year_of_study = $_POST['year_of_study'];

    $stmt = $conn->prepare("UPDATE students SET reg_number=?, full_name=?, course=?, year_of_study=? WHERE id=?");
    $stmt->bind_param("ssssi", $reg_number, $full_name, $course, $year_of_study, $id);

    if($stmt->execute()){
        $success = "Student updated successfully!";
    } else {
        $error = "Error updating student.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Students</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h3 class="mb-4">Manage Students</h3>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>


<!-- ADD STUDENT FORM -->
<div class="card p-4 mb-4 shadow">
<h5>Add Student</h5>
<form method="POST">
    <div class="mb-3">
        <input type="text" name="reg_number" class="form-control" placeholder="Registration Number" required>
    </div>
    <div class="mb-3">
        <input type="text" name="full_name" class="form-control" placeholder="Student Name" required>
    </div>
    <div class="mb-3">
        <input type="text" name="course" class="form-control" placeholder="Course" required>
    </div>
    <div class="mb-3">
        <input type="text" name="year_of_study" class="form-control" placeholder="Year of Study" required>
    </div>
    <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
</form>
</div>


<!-- STUDENT TABLE -->
<div class="card p-4 shadow">
<h5>All Students</h5>
<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Reg Number</th>
    <th>Name</th>
    <th>Course</th>
    <th>Year</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
while($row = $result->fetch_assoc()){
?>

<tr>
<form method="POST">
    <td><?php echo $row['id']; ?></td>
    <td>
        <input type="text" name="reg_number" value="<?php echo $row['reg_number']; ?>" class="form-control">
    </td>
    <td>
        <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" class="form-control">
    </td>
    <td>
        <input type="text" name="course" value="<?php echo $row['course']; ?>" class="form-control">
    </td>
    <td>
        <input type="text" name="year_of_study" value="<?php echo $row['year_of_study']; ?>" class="form-control">
    </td>
    <td>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="submit" name="update_student" class="btn btn-success btn-sm">Update</button>
        <a href="student_crud.php?delete=<?php echo $row['id']; ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this student?')">Delete</a>
    </td>
</form>
</tr>

<?php } ?>

</table>
</div>

<a href="../lecturer/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

</div>
</body>
</html>