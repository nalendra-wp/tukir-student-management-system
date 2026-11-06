
<?php
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

require_once 'config06931.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $alamat = trim($_POST['alamat'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $kota = trim($_POST['kota'] ?? '');
    $ipk = $_POST['ipk'] ?? '';

    if (
        $nim === '' || $nama === '' || $alamat === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'], true) ||
        !is_numeric($ipk) || $ipk < 0 || $ipk > 4
    ) {
        $message = 'Please enter valid student information.';
    } else {
        $sql = "UPDATE mahasiswa06931
                SET Nama = ?, JenisKelamin = ?, Alamat = ?,
                    Email = ?, Kota = ?, IPK = ?
                WHERE Nim = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $ipk = (float) $ipk;
            $stmt->bind_param(
                "sssssds",
                $nama,
                $jenis_kelamin,
                $alamat,
                $email,
                $kota,
                $ipk,
                $nim
            );

            if ($stmt->execute()) {
                $message = $stmt->affected_rows > 0
                    ? 'Student data updated successfully.'
                    : 'No changes made or student data not found.';
            } else {
                $message = 'Failed to update student data.';
            }

            $stmt->close();
        } else {
            $message = 'Unable to process the update.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mahasiswa</title>
</head>
<body>
    <h1>Update Mahasiswa</h1>

    <?php if ($message !== ''): ?>
        <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="post" action="upd_mhs06931.php">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        <br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>
        <br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <input type="radio" name="jenis_kelamin" value="Laki-laki" required>Laki-laki
        <input type="radio" name="jenis_kelamin" value="Perempuan" required>Perempuan
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
        <input type="number" id="ipk" name="ipk"
               min="0" max="4" step="0.01" required>
        <br>

        <button type="submit">Update</button>
    </form>

    <a href="homeadmin06931.php">Kembali ke Home Admin</a>
</body>
</html>
