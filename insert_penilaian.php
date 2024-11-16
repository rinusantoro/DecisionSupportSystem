<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['nilai'])) {
    $id_guru = $_GET['id'];
    $nilai_akhir = $_GET['nilai'];
    
    $cekGuru = "SELECT guru_id from penilaian where guru_id= '$id_guru'";
    
    if($conn->query($cekGuru) === FALSE){
        // Insert data ke tabel penilaian
        $sql = "INSERT INTO penilaian (guru_id, nilai_akhir) VALUES ('$id_guru', '$nilai_akhir')";

        if ($conn->query($sql) === TRUE) {
            echo "Penilaian berhasil disimpan.";
            header('Location: laporan.php?status=success');
        } else {
            echo "Error: " . $conn->error;
        }        
    }else{
        // Insert data ke tabel penilaian
        $sql = "UPDATE penilaian SET nilai_akhir = '$nilai_akhir' WHERE id='$id_guru'";
        if ($conn->query($sql) === TRUE) {
            echo "Penilaian berhasil disimpan.";
            header('Location: laporan.php?status=success');
        } else {
            echo "Error: " . $conn->error;
        }
    }

} else {
    echo "Data tidak valid!";
}

$conn->close();
?>
