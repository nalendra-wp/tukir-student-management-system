
<?php
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

require_once 'config06931.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$nim = $nama = $jenisKelamin = $alamat = $email = $kota = $ipk = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (
        !isset($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $csrf_token)
    ) {
        $error = 'Invalid request. Please refresh the page and try again.';
    } else {
        $nim = trim($_POST['nim'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $jenisKelamin = $_POST['jenis_kelamin'] ?? '';
        $alamat = trim($_POST['alamat'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $kota = trim($_POST['kota'] ?? '');
        $ipk = trim($_POST['ipk'] ?? '');

        if (
            $nim === '' || $nama === '' || $jenisKelamin === '' ||
            $alamat === '' || $email === '' || $kota === '' || $ipk === ''
        ) {
            $error = 'Semua kolom wajib diisi.';
        } elseif (!in_array($jenisKelamin, ['Laki-laki', 'Perempuan'], true)) {
            $error = 'Jenis kelamin tidak valid.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Format email tidak valid.';
        } elseif (!is_numeric($ipk) || (float)$ipk < 0 || (float)$ipk > 4) {
            $error = 'IPK harus berupa angka antara 0.00 sampai 4.00.';
        } elseif (strlen($nim) > 15 || strlen($nama) > 100) {
            $error = 'NIM atau nama melebihi batas karakter.';
        } elseif (
            strlen($alamat) > 255 ||
            strlen($email) > 100 ||
            strlen($kota) > 100
        ) {
            $error = 'Alamat, email, atau kota melebihi batas karakter.';
        } else {
            $sql = "INSERT INTO mahasiswa06931
                    (Nim, Nama, JenisKelamin, Alamat, Email, Kota, IPK)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $ipkValue = (float)$ipk;

                $stmt->bind_param(
                    "ssssssd",
                    $nim,
                    $nama,
                    $jenisKelamin,
                    $alamat,
                    $email,
                    $kota,
                    $ipkValue
                );

                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();

                    header('Location: homeadmin06931.php');
                    exit();
                } else {
                    if ($stmt->errno === 1062) {
                        $error = 'NIM sudah terdaftar.';
                    } else {
                        $error = 'Gagal menambahkan data mahasiswa.';
                    }
                }

                $stmt->close();
            } else {
                $error = 'Tidak dapat memproses data. Silakan coba lagi.';
            }
        }
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        form input[type=number],
        form select,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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

        .error {
            max-width: 600px;
            margin: 20px auto;
            padding: 12px;
            background-color: #ffcccc;
            color: #990000;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Tambah Data Mahasiswa</h1>

    <?php if ($error !== ''): ?>
        <div class="error"><?php echo e($error); ?></div>
    <?php endif; ?>

    <form method="post" action="tambahdata06931.php" accept-charset="UTF-8">
        <input type="hidden" name="csrf_token"
               value="<?php echo e($_SESSION['csrf_token']); ?>">

        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim"
               maxlength="15" value="<?php echo e($nim); ?>" required>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama"
               maxlength="100" value="<?php echo e($nama); ?>" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki-laki" <?php echo $jenisKelamin === 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
            <option value="Perempuan" <?php echo $jenisKelamin === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
        </select>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" maxlength="255" required><?php echo e($alamat); ?></textarea>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               maxlength="100" value="<?php echo e($email); ?>" required>

        <label for="kota">Kota:</label>
        <input type="text" id="kota" name="kota"
               maxlength="100" value="<?php echo e($kota); ?>" required>

        <label for="ipk">IPK:</label>
        <input type="number" id="ipk" name="ipk"
               min="0" max="4" step="0.01"
               value="<?php echo e($ipk); ?>" required>

        <input type="submit" value="Submit">
    </form>

    <br>
    <a href="homeadmin06931.php" class="logout">Kembali ke Home Admin</a>
</body>
</html>
