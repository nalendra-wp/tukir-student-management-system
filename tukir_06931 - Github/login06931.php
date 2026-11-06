<?php
session_start();
require 'validasi06931.php'; 
require 'config06931.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin06931 WHERE username='$username'";
    $result = $conn->query($sql);
    $ada = $result->num_rows > 0;
    if ($ada) {
        while ($row = $result->fetch_assoc()) {
            $db_password = $row["password"];
        }
    }
    $conn->close();

    if ($ada && validasi($password, $db_password)) {
        $_SESSION['admin06931'] = $username;
        header('Location: homeadmin06931.php');
        exit();
    } else {
        echo "<p class='error'>Invalid username or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://images.pexels.com/photos/1103970/pexels-photo-1103970.jpeg?cs=srgb&dl=pexels-jplenio-1103970.jpg&fm=jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box; /* tambahkan untuk memastikan padding dihitung dalam lebar */
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .login-container input {
            width: 100%; /* membuat input memenuhi lebar container */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* pastikan padding dihitung dalam lebar */
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #0078d4;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0047ab;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="post" action="login06931.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
