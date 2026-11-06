<?php
require 'config06931.php';
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

$sql = "SELECT * FROM mahasiswa06931";
$result = $conn->query($sql);

$ada = $result->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Mahasiswa</title>
    <style>
        * {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Kota</th>
            <th>IPK</th>
        </tr>
        <?php
        if ($ada) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Nim']}</td>";
                echo "<td>{$row['Nama']}</td>";
                echo "<td>{$row['JenisKelamin']}</td>";
                echo "<td>{$row['Alamat']}</td>";
                echo "<td>{$row['Email']}</td>";
                echo "<td>{$row['Kota']}</td>";
                echo "<td>{$row['IPK']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <script>
        window.print();
    </script>
</body>
</html>
