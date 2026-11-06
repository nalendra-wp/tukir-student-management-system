
<?php
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

require_once 'config06931.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: homeadmin06931.php');
    exit();
}

$nim = trim($_POST['Nim'] ?? '');
$csrf_token = $_POST['csrf_token'] ?? '';

if (
    $nim === '' ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $csrf_token)
) {
    header('Location: homeadmin06931.php');
    exit();
}

$sql = "DELETE FROM mahasiswa06931 WHERE Nim = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

header('Location: homeadmin06931.php');
exit();
