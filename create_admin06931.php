
<?php
require_once 'config06931.php';

$username = 'admin';
$password = 'GantiPasswordKuatDiSini';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO admin06931 (username, password) VALUES (?, ?)"
);

$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Admin account created successfully.";
} else {
    echo "Unable to create admin account.";
}

$stmt->close();
$conn->close();
?>
