<?php
session_start();
include 'style.php';

$conn = connectToDatabase();

$action = $_GET['action'] ?? '';
$id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

if ($action === 'edit') {
    // Edit action
    $school = isset($_POST['school']) ? $conn->real_escape_string($_POST['school']) : null;
    $school_content = isset($_POST['school_content']) ? $conn->real_escape_string($_POST['school_content']) : null;
    $year = isset($_POST['year']) ? $conn->real_escape_string($_POST['year']) : null;

    if ($id && $school && $school_content && $year) {
        $stmt = $conn->prepare("UPDATE education SET school = ?, school_content = ?, year = ? WHERE id = ?");
        $stmt->bind_param('sssi', $school, $school_content, $year, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Education details updated successfully.'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating education details: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
        }
        $stmt->close();
    }
} elseif ($action === 'delete' && $id !== null) {
    // Delete action
    $stmt = $conn->prepare("DELETE FROM education WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo "<script>alert('Education details deleted successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error deleting education details: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
    }
    $stmt->close();
} elseif ($action === 'add') {
    // Add action
    $school = isset($_POST['school']) ? $conn->real_escape_string($_POST['school']) : null;
    $school_content = isset($_POST['school_content']) ? $conn->real_escape_string($_POST['school_content']) : null;
    $year = isset($_POST['year']) ? $conn->real_escape_string($_POST['year']) : null;

    if ($school && $school_content && $year) {
        $stmt = $conn->prepare("INSERT INTO education (school, school_content, year) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $school, $school_content, $year);
        if ($stmt->execute()) {
            echo "<script>alert('Education details added successfully.'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Error adding education details: " . $stmt->error . "'); window.location.href = 'dashboard.php';</script>";
        }
        $stmt->close();
    }
}

$conn->close();
?>
