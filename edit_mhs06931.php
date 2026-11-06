<?php
require 'config06931.php';
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['Nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $kota = $_POST['kota'];
    $ipk = $_POST['ipk'];

    // Update data in database
    $sql = "UPDATE mahasiswa06931 SET Nama=?, JenisKelamin=?, Alamat=?, Email=?, Kota=?, IPK=? WHERE Nim=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nama, $jenis_kelamin, $alamat, $email, $kota, $ipk, $nim);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = 'homeadmin06931.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data'); window.location.href = 'edit_mhs06931.php?Nim=$nim';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    if (isset($_GET['Nim'])) {
        $nim = $_GET['Nim'];

        // Fetch data based on Nim
        $sql = "SELECT * FROM mahasiswa06931 WHERE Nim = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "Record not found";
            exit();
        }

        $row = $result->fetch_assoc();

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        header('Location: homeadmin06931.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
            
        }
        body {
            background-color: #f0f0f0; /* Warna latar belakang halaman */
            background-image: url('https://images.pexels.com/photos/1103970/pexels-photo-1103970.jpeg?cs=srgb&dl=pexels-jplenio-1103970.jpg&fm=jpg'); /* Ganti dengan path gambar latar belakang Anda */
            background-size: cover; /* Agar gambar latar belakang mengisi seluruh area body */
            background-position: center; /* Posisikan gambar latar belakang ke tengah */
            background-repeat: no-repeat; /* Agar gambar tidak diulang */
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
            
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .radio-label {
            margin-right: 20px;
        }

        .submit-btn {
            background-color: #0047ab;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .jeniskel {
            display: flex;
            align-items: start;
            
        }
    </style>
</head>

<body>
    <h2>Edit Mahasiswa</h2>
    <form action="edit_mhs06931.php" method="POST">
        <input type="hidden" name="Nim" value="<?php echo $row['Nim']; ?>">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" value="<?php echo $row['Nim']; ?>" readonly>
        

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $row['Nama']; ?>" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <div class="jeniskel">
            <input type="radio" id="laki_laki" name="jenis_kelamin" value="Laki-laki" <?php echo ($row['JenisKelamin'] == 'Laki-laki') ? 'checked' : ''; ?>>
            <label class="radio-label" for="laki_laki">Laki-laki</label>
            <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" <?php echo ($row['JenisKelamin'] == 'Perempuan') ? 'checked' : ''; ?>>
            <label class="radio-label" for="perempuan">Perempuan</label>

        </div>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $row['Alamat']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" required>

        <label for="kota">Kota:</label>
        <select id="kota" name="kota" required>
            <option value="Semarang" <?php echo ($row['Kota'] == 'Semarang') ? 'selected' : ''; ?>>Semarang</option>
            <option value="Jepara" <?php echo ($row['Kota'] == 'Jepara') ? 'selected' : ''; ?>>Jepara</option>
            <option value="Salatiga" <?php echo ($row['Kota'] == 'Salatiga') ? 'selected' : ''; ?>>Salatiga</option>
            <option value="Dll" <?php echo ($row['Kota'] == 'Dll') ? 'selected' : ''; ?>>Dll</option>
        </select>

        <label for="ipk">IPK:</label>
        <input type="text" id="ipk" name="ipk" value="<?php echo $row['IPK']; ?>" required>

        <button type="submit" class="submit-btn">Simpan Perubahan</button>
    </form>
</body>

</html>