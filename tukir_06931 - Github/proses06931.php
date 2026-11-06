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
    
    $sql = "INSERT INTO mahasiswa06931 (Nim, Nama, JenisKelamin, Alamat, Email, Kota, IPK) VALUES ('$Nim', '$Nama', '$JenisKelamin', '$Alamat', '$Email', '$Kota', '$IPK')";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan";
    } else {
        echo "Error: " . $conn->error;
    }
}
header("Location: upd_mhs06931.php");
?>
