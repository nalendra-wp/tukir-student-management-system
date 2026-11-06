
<?php
session_start();
require_once 'config06931.php';

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$sql = "SELECT * FROM mahasiswa06931";
$result = $conn->query($sql);

$ada = $result && $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background-color: #0047ab;
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
            overflow-x: auto;
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
            background-color: #0047ab;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .action-buttons a,
        .action-buttons button {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 3px;
            text-decoration: none;
            color: white;
            margin: 2px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .edit {
            background-color: #0078d4;
        }

        .delete {
            background-color: #bf0016;
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
            background-color: #0047ab;
        }

        .cetak {
            background-color: #0078d4;
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
            document.getElementById('deleteForm').submit();
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

            <?php if ($ada): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Nim'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['Nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['JenisKelamin'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['Alamat'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['Email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['Kota'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['IPK'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                        <td class="action-buttons">
                            <a href="edit_mhs06931.php?Nim=<?php echo urlencode($row['Nim']); ?>"
                               class="edit">Edit</a>
                        </td>

                        <td class="action-buttons">
                            <button type="button"
                                    class="delete"
                                    onclick="confirmDelete(this.dataset.nim)"
                                    data-nim="<?php echo htmlspecialchars($row['Nim'], ENT_QUOTES, 'UTF-8'); ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>

            <?php $conn->close(); ?>
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

            <form id="deleteForm" action="hapus06931.php" method="POST">
                <input type="hidden" name="Nim" id="deleteNim">

                <input type="hidden" name="csrf_token"
                       value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

                <button type="button" class="yes" onclick="proceedDelete()">Iya</button>
                <button type="button" class="no" onclick="closeModal()">Tidak</button>
            </form>
        </div>
    </div>
</body>
</html>
