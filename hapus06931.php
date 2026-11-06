<?php
require 'config06931.php';
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

if (isset($_GET['Nim'])) {
    $nim = $_GET['Nim'];

    // Prepare the SQL delete statement
    $sql = "DELETE FROM mahasiswa06931 WHERE Nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nim);

    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully'); window.location.href = 'homeadmin06931.php';</script>";
    } else {
        echo "<script>alert('Error deleting record'); window.location.href = 'homeadmin06931.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: homeadmin06931.php');
    exit();
}
?>
