<?php
include('conn.php');
session_start();
include('functions.php');

// Ensure default admin exists if table is empty
$check_admin = "SELECT COUNT(*) AS total FROM admin";
$result = mysqli_query($con, $check_admin);
$data = mysqli_fetch_assoc($result);

if ($data['total'] == 0) {
    $default_name = 'admin';
    $default_password = password_hash('admin123', PASSWORD_DEFAULT); // Hash password for security
    $insert_default_admin = "INSERT INTO admin (name, password) VALUES ('$default_name', '$default_password')";
    mysqli_query($con, $insert_default_admin);
}

// Handle login submission
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $select_query = "SELECT * FROM admin WHERE name='$username'";
    $result = mysqli_query($con, $select_query);
    $row_data = mysqli_fetch_assoc($result);

    if ($row_data) {
        if (password_verify($password, $row_data['password'])) {
            $_SESSION['user'] = $username; // Set session
            echo "<script>alert('Login successful!')</script>";
            echo "<script>window.open('admin_dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Invalid password!')</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials!')</script>";
    }
}
?>
