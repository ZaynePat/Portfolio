<?php
session_start();
include 'style.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase(); 

    $id = $conn->real_escape_string($_POST['id']);

    $sql = "DELETE FROM contact WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Message deleted successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error deleting message: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


