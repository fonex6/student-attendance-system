<?php
session_start();
include "../config/database.php";

// Grab POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check if admin exists
$sql = "SELECT * FROM users WHERE username='$username' AND role='admin' LIMIT 1";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $admin = $result->fetch_assoc();

    // For demo, assuming password stored plain text
    // If hashed: use password_verify($password, $admin['password']);
    if($password === $admin['password']){
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: dashboard.php"); // redirect to dashboard
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid password!";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['login_error'] = "Admin not found!";
    header("Location: ../index.php");
    exit();
}