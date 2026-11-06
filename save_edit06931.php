<?php
include 'config06931.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nim = $_POST['Nim'];
    $Nama = $_POST['Nama'];
    $JenisKelamin = $_POST['JenisKelamin'];
    $Alamat = $_POST['Alamat'];
    $Email = $_POST['Email'];
    $Kota = $_POST['Kota'];
    $IPK = $_POST['IPK'];
    
    $sql = "UPDATE mahasiswa06931 SET Nama='$Nama', JenisKelamin='$JenisKelamin', Alamat='$Alamat', Email='$Email', Kota='$Kota', IPK='$IPK' WHERE Nim='$Nim'";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error: " . $conn->error;
    }
}
header("Location: upd_mhs06931.php");
?>
