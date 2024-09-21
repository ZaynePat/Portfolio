<?php
include 'style.php'; 
//include 'connection/dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase(); 

    
    $username = $conn->real_escape_string($_POST['username']); // Escape username
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password


    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. Please login.')</script>";
        // Redirect to login page
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Register</h2>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

