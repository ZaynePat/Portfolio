<?php
include 'style.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $home_content = $conn->real_escape_string($_POST['home_content']);
    $name = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['position']);

    $sql = "UPDATE home SET home_content=?, name=?, position=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $home_content, $name, $position);

    if ($stmt->execute()) {
        echo "<script>alert('Home content updated successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating home content: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
    }

    $stmt->close();
}
?>
