<?php
include 'database.php'; // Ensure this file contains the correct database connection details

// Fetch POST data and sanitize
$uname = isset($_POST['uname']) ? mysqli_real_escape_string($conn, $_POST['uname']) : '';
$useremail = isset($_POST['useremail']) ? mysqli_real_escape_string($conn, $_POST['useremail']) : '';
$pass = isset($_POST['pass']) ? mysqli_real_escape_string($conn, $_POST['pass']) : '';

// Simple password hashing for security
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Insert query
$query = "INSERT INTO students (username, email, password) VALUES ('$uname', '$useremail', '$hashed_password')";
$res = mysqli_query($conn, $query);

// Output result code only
if ($res) {
    echo "1"; // Success
} else {
    echo "0"; // Failure
    // For debugging purposes, uncomment the next line to see the error
    // echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
