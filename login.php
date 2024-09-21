<?php
session_start(); 

include 'style.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = connectToDatabase();

    // Escape username and password
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();


    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            echo "<script>alert('Login successful. Welcome, " . htmlspecialchars($username) . "!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
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
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a href="register.php" class="btn btn-secondary btn-block">Register</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
