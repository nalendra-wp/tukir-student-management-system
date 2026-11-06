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
$username = $_SESSION['username'];
$password = $_SESSION['password'];
echo "<h1>Halaman Administrator</h1>";
echo "<p style='background-color: #ffcccc; padding: 10px; border-radius: 5px; text-align: center;'>Anda berhasil login dengan Admin</p>";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        * {
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
        }
        body {
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('https://images.pexels.com/photos/1103970/pexels-photo-1103970.jpeg?cs=srgb&dl=pexels-jplenio-1103970.jpg&fm=jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }
        h1 {
            background-color: #0047ab; /* Updated to biru udinus */
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #0047ab; /* Updated to biru udinus */
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        .action-buttons a {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 3px;
            text-decoration: none;
            color: white;
            margin: 2px;
        }
        .edit {
            background-color: #0078d4; /* Lighter blue for Edit */
        }
        .delete {
            background-color: #bf0016; /* Bright red for Delete */
        }
        .tambah, .cetak, .logout {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin-top: 20px;
        }
        .tambah {
            background-color: #0047ab; /* Updated to biru udinus */
        }
        .cetak {
            background-color: #0078d4; /* Lighter blue */
            margin-left: 10px;
        }
        .logout {
            background-color: gray;
            margin-left: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
        }
        .modal-content button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .yes {
            background-color: #0047ab;
            color: white;
        }
        .no {
            background-color: #bf0016;
            color: white;
        }
    </style>
    <script>
        function confirmDelete(Nim) {
            document.getElementById('confirmModal').style.display = 'block';
            document.getElementById('deleteNim').value = Nim;
        }
        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }
        function proceedDelete() {
            var Nim = document.getElementById('deleteNim').value;
            window.location.href = "hapus06931.php?Nim=" + Nim;
        }
    </script>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <div class="container">
        <table>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Kota</th>
                <th>IPK</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            if ($ada) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['Nim']; ?></td>
                        <td><?php echo $row['Nama']; ?></td>
                        <td><?php echo $row['JenisKelamin']; ?></td>
                        <td><?php echo $row['Alamat']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Kota']; ?></td>
                        <td><?php echo $row['IPK']; ?></td>
                        <td class="action-buttons">
                            <a href="edit_mhs06931.php?Nim=<?php echo $row['Nim']; ?>" class="edit">Edit</a>
                        </td>
                        <td class="action-buttons">
                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo $row['Nim']; ?>')" class="delete">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        <div style="text-align: right;">
            <a href="tambahdata06931.php" class="tambah">Tambah Data</a>
            <a href="cetak_mahasiswa06931.php" class="cetak">Cetak Mahasiswa</a>
            <a href="logout06931.php" class="logout">Logout</a>
        </div>
    </div>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Apakah Yakin Ingin Menghapus Data?</p>
            <button class="yes" onclick="proceedDelete()">Iya</button>
            <button class="no" onclick="closeModal()">Tidak</button>
            <input type="hidden" id="deleteNim" value="">
        </div>
    </div>
</body>
</html>

