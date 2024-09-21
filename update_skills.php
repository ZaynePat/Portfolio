<?php
session_start();
include 'style.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase(); 

    $property = $conn->real_escape_string($_POST['property']);
    $value = $conn->real_escape_string($_POST['value']);

    $sql = "UPDATE skills SET value=? WHERE property=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $value, $property);

    if ($stmt->execute()) {
        echo "<script>alert('Skill updated successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating skill: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
