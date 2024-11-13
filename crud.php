<?php
include 'database.php';

$action = $_POST['action'] ?? '';
$response = [];

if ($action == 'create') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO students (username, email, password) VALUES ('$username', '$email', '$password')";
    $result = mysqli_query($conn, $query);

    $response['message'] = $result ? 'Student added successfully' : 'Failed to add student';

} elseif ($action == 'update') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "UPDATE students SET username='$username', email='$email', password='$password' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    $response['message'] = $result ? 'Student updated successfully' : 'Failed to update student';

} elseif ($action == 'delete') {
    $id = $_POST['id'];

    $query = "DELETE FROM students WHERE id=$id";
    $result = mysqli_query($conn, $query);

    $response['message'] = $result ? 'Student deleted successfully' : 'Failed to delete student';
}

mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
