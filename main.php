<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mt-4 p-5 bg-primary text-white rounded">
            <h1 class="text-center">Student CRUD Operations Using jQuery and Ajax</h1>
        </div>

        <!-- Form for Adding/Updating Students -->
        <form id="studentForm" class="mt-4">
            <input type="hidden" id="studentId">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </form>

        <!-- Table for displaying students -->
        <table class="table mt-4" id="studentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load student data
            function loadStudents() {
                $.ajax({
                    url: 'read.php',
                    method: 'GET',
                    success: function(data) {
                        $('#studentsTable tbody').html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error loading students:', textStatus, errorThrown);
                    }
                });
            }

            loadStudents(); // Initial load

            // Add/Update student
            $('#studentForm').submit(function(e) {
                e.preventDefault();

                var id = $('#studentId').val();
                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var action = id ? 'update' : 'create';

                $.ajax({
                    url: 'crud.php',
                    method: 'POST',
                    data: {
                        action: action,
                        id: id,
                        username: username,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        });
                        $('#studentForm')[0].reset();
                        $('#studentId').val('');
                        $('#saveBtn').text('Save');
                        loadStudents(); // Reload the student list
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error'
                        });
                    }
                });
            });

            // Edit student
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: 'read.php',
                    method: 'GET',
                    data: { id: id },
                    success: function(response) {
                        var student = JSON.parse(response);
                        $('#studentId').val(student.id);
                        $('#username').val(student.username);
                        $('#email').val(student.email);
                        $('#password').val(student.password);
                        $('#saveBtn').text('Update');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching student data:', textStatus, errorThrown);
                    }
                });
            });

            // Delete student
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'crud.php',
                            method: 'POST',
                            data: {
                                action: 'delete',
                                id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success'
                                });
                                loadStudents(); // Reload the student list
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error:', textStatus, errorThrown);
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
