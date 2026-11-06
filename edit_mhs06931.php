
<?php
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

require_once 'config06931.php';

$message = '';
$nim = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['Nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $alamat = trim($_POST['alamat'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $kota = trim($_POST['kota'] ?? '');
    $ipk = $_POST['ipk'] ?? '';

    if (
        $nim === '' ||
        $nama === '' ||
        $alamat === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'], true) ||
        !is_numeric($ipk) ||
        $ipk < 0 ||
        $ipk > 4
    ) {
        $message = 'Please enter valid student information.';
    } else {
        $ipk = (float) $ipk;

        $sql = "UPDATE mahasiswa06931
                SET Nama = ?, JenisKelamin = ?, Alamat = ?,
                    Email = ?, Kota = ?, IPK = ?
                WHERE Nim = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
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
                $message = 'Data berhasil diperbarui.';
            } else {
                $message = 'Gagal memperbarui data.';
            }

            $stmt->close();
        } else {
            $message = 'Unable to process the update.';
        }
    }
} elseif (isset($_GET['Nim'])) {
    $nim = trim($_GET['Nim']);
} else {
    header('Location: homeadmin06931.php');
    exit();
}

// Ambil data mahasiswa
$sql = "SELECT * FROM mahasiswa06931 WHERE Nim = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('Unable to retrieve student data.');
}

$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    die('Record not found.');
}

$row = $result->fetch_assoc();

$stmt->close();
$conn->close();

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            background-image: url('https://images.pexels.com/photos/1103970/pexels-photo-1103970.jpeg?cs=srgb&dl=pexels-jplenio-1103970.jpg&fm=jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
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
        input[type="number"],
        select {
            width: 100%;
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
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #003580;
        }

        .jeniskel {
            display: flex;
            align-items: center;
        }

        .message {
            max-width: 600px;
            margin: 15px auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin: 20px;
        }
    </style>
</head>

<body>

    <h2>Edit Mahasiswa</h2>

    <?php if ($message !== ''): ?>
        <p class="message"><?= e($message); ?></p>
    <?php endif; ?>

    <form action="edit_mhs06931.php" method="POST">

        <input type="hidden" name="Nim" value="<?= e($row['Nim']); ?>">

        <label for="nim">NIM:</label>
        <input type="text" id="nim" value="<?= e($row['Nim']); ?>" readonly>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama"
               value="<?= e($row['Nama']); ?>" required>

        <label>Jenis Kelamin:</label>

        <div class="jeniskel">
            <input type="radio" id="laki_laki"
                   name="jenis_kelamin" value="Laki-laki"
                   <?= $row['JenisKelamin'] === 'Laki-laki' ? 'checked' : ''; ?>
                   required>

            <label class="radio-label" for="laki_laki">Laki-laki</label>

            <input type="radio" id="perempuan"
                   name="jenis_kelamin" value="Perempuan"
                   <?= $row['JenisKelamin'] === 'Perempuan' ? 'checked' : ''; ?>>

            <label class="radio-label" for="perempuan">Perempuan</label>
        </div>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat"
               value="<?= e($row['Alamat']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="<?= e($row['Email']); ?>" required>

        <label for="kota">Kota:</label>
        <select id="kota" name="kota" required>
            <?php
            $cities = array_unique([
                $row['Kota'],
                'Semarang',
                'Jepara',
                'Salatiga',
                'Surabaya',
                'Jakarta',
                'Bandung',
                'Dll'
            ]);

            foreach ($cities as $city):
            ?>
                <option value="<?= e($city); ?>"
                    <?= $row['Kota'] === $city ? 'selected' : ''; ?>>
                    <?= e($city); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="ipk">IPK:</label>
        <input type="number" id="ipk" name="ipk"
               value="<?= e($row['IPK']); ?>"
               min="0" max="4" step="0.01" required>

        <button type="submit" class="submit-btn">
            Simpan Perubahan
        </button>

    </form>

    <a class="back-link" href="homeadmin06931.php">
        Kembali ke Home Admin
    </a>

</body>
</html>
