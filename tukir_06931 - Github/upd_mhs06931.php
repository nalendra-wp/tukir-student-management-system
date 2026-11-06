<?php
session_start();
if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $kota = $_POST['kota'];
    $ipk = $_POST['ipk'];

    // Proses update data ke database (contoh)
    $conn = new mysqli('localhost', 'root', '', 'nama_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE mahasiswa06931 SET nama=?, jenis_kelamin=?, alamat=?, email=?, kota=?, ipk=? WHERE nim=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $nama, $jenis_kelamin, $alamat, $email, $kota, $ipk, $nim);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil diupdate.";
    } else {
        echo "Update gagal atau data tidak berubah.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Mahasiswa</title>
</head>
<body>
    <h1>Update Mahasiswa</h1>
    <form method="post" action="upd_mhs.php">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        <br>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>
        <br>
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <input type="radio" id="jenis_kelamin_l" name="jenis_kelamin" value="L" required>Laki-laki
        <input type="radio" id="jenis_kelamin_p" name="jenis_kelamin" value="P" required>Perempuan
        <br>
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="kota">Kota:</label>
        <select id="kota" name="kota" required>
            <option value="Jakarta">Jakarta</option>
            <option value="Surabaya">Surabaya</option>
            <option value="Bandung">Bandung</option>
        </select>
        <br>
        <label for="ipk">IPK:</label>
        <input type="text" id="ipk" name="ipk" required>
        <br>
        <button type="submit">Update</button>
    </form>
    <a href="homeadmin06931.php">Kembali ke Home Admin</a>
</body>
</html>
