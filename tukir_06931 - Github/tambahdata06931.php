<?php
require 'config06931.php';
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

// Initialize variables for form input
$nim = $nama = $jenisKelamin = $alamat = $email = $kota = $ipk = '';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenisKelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $kota = $_POST['kota'];
    $ipk = $_POST['ipk'];

    // Insert into database
    $sql = "INSERT INTO mahasiswa06931 (Nim, Nama, JenisKelamin, Alamat, Email, Kota, IPK) 
            VALUES ('$nim', '$nama', '$jenisKelamin', '$alamat', '$email', '$kota', '$ipk')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Mahasiswa</title>
    <style>
        * {
            font-family: sans-serif;
            box-sizing: border-box;
        }
        body {
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            background-image: url('https://images.pexels.com/photos/1103970/pexels-photo-1103970.jpeg?cs=srgb&dl=pexels-jplenio-1103970.jpg&fm=jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            
        }
        h1 {
            background-color: #0078d4;
            color: white;
            padding: 10px;
            text-align: center;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        form input[type=text],
        form input[type=email],
        form select,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form input[type=submit] {
            background-color: #0047ab;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        form input[type=submit]:hover {
            background-color: #0078d4;
        }
        .logout {
            color: white;
            border-radius: 5px;
            text-decoration: none;
            background-color: gray;
            margin-top: 20px;
            padding: 8px 12px;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>
        
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required></textarea>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="kota">Kota:</label>
        <input type="text" id="kota" name="kota" required>
        
        <label for="ipk">IPK:</label>
        <input type="text" id="ipk" name="ipk" required>
        
        <input  type="submit" value="Submit">
    </form>
    <br/>
    <a href="homeadmin06931.php" class="logout">Kembali ke Home Admin</a>
</body>
</html>
