<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM guru";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include 'navigasi.php'; ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
                <h4>Data Guru</h4>
        </div>
            <div class="card-body">
                
<?php
echo "<table class='table table-bordered'>
        <thead>
            <tr>
                <th>Nama Guru</th>
                <th>Absensi</th>
                <th>Prestasi Kerja</th>
                <th>Prestasi Individual</th>
                <th>Skema Nasional</th>
                <th>Sertifikasi Guru</th>
                <th>Nilai Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>";

while($row = $result->fetch_assoc()) {
    $id_guru = $row['id'];
    $nilai_total = $row['nilai_total'];

    echo "<tr>
            <td>" . $row['nama_guru'] . "</td>
            <td>" . $row['absensi'] . "</td>
            <td>" . $row['prestasi_kerja'] . "</td>
            <td>" . $row['prestasi_individual'] . "</td>
            <td>" . $row['skema_nasional'] . "</td>
            <td>" . ($row['sertifikasi_guru'] == 1 ? 'Punya' : 'Tidak Punya') . "</td>
            <td>" . $row['nilai_total'] . "</td>
            <td>
                <a href='edit_guru.php?id=$id_guru' class='btn btn-warning btn-sm'>Edit</a>
                <a href='insert_penilaian.php?id=$id_guru&nilai=$nilai_total' class='btn btn-success btn-sm'>Insert Penilaian</a>
            </td>
        </tr>";
}
?>
            
        </div>
    </div>
</div>

<?php
echo "</tbody>
      </table>";
?>
