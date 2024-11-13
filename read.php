<?php
include 'database.php';

if (isset($_GET['id'])) {
    // Get a single student's data for editing
    $id = $_GET['id'];
    $query = "SELECT * FROM students WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $student = mysqli_fetch_assoc($result);
        echo json_encode($student);
    } else {
        echo json_encode(['error' => 'Student not found']);
    }
} else {
    // Get all students' data
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm edit-btn' data-id='{$row['id']}'>Edit</button>
                        <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No students found</td></tr>";
    }
}

mysqli_close($conn);
?>
