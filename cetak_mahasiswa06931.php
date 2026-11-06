

<?php
session_start();

if (!isset($_SESSION['admin06931'])) {
    header('Location: login06931.php');
    exit();
}

require_once 'config06931.php';

$sql = "SELECT * FROM mahasiswa06931 ORDER BY Nim ASC";
$result = $conn->query($sql);

if (!$result) {
    $conn->close();
    die('Unable to retrieve student data.');
}

$ada = $result->num_rows > 0;

function e($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Mahasiswa</title>

    <style>
        * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #0047ab;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #0047ab;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            margin-bottom: 20px;
            text-align: right;
        }

        .actions button,
        .actions a {
            display: inline-block;
            padding: 9px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .print {
            background-color: #0047ab;
        }

        .back {
            background-color: gray;
            margin-left: 5px;
        }

        @media print {
            body {
                margin: 0;
            }

            .actions {
                display: none;
            }

            h1 {
                color: black;
            }

            th {
                background-color: #ddd !important;
                color: black !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <h1>Data Mahasiswa</h1>

    <div class="actions">
        <button class="print" onclick="window.print()">Cetak Data</button>
        <a href="homeadmin06931.php" class="back">Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Kota</th>
                <th>IPK</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($ada): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo e($row['Nim']); ?></td>
                        <td><?php echo e($row['Nama']); ?></td>
                        <td><?php echo e($row['JenisKelamin']); ?></td>
                        <td><?php echo e($row['Alamat']); ?></td>
                        <td><?php echo e($row['Email']); ?></td>
                        <td><?php echo e($row['Kota']); ?></td>
                        <td><?php echo e($row['IPK']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">
                        Tidak ada data
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>
