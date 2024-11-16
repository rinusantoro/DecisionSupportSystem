<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_guru = $_POST['nama_guru'];
    $absensi = $_POST['absensi'];
    $prestasi_kerja = $_POST['prestasi_kerja'];
    $prestasi_individual = $_POST['prestasi_individual'];
    $skema_nasional = $_POST['skema_nasional'];
    $sertifikasi_guru = $_POST['sertifikasi_guru'];

    // Penilaian berdasarkan kriteria
    // Nilai Absensi
    if ($absensi >= 95) {
        $nilai_absensi = 3;
    } elseif ($absensi >= 70) {
        $nilai_absensi = 2;
    } else {
        $nilai_absensi = 1;
    }

    // Nilai Prestasi Kerja
    if ($prestasi_kerja > 3) {
        $nilai_prestasi_kerja = 3;
    } elseif ($prestasi_kerja > 0) {
        $nilai_prestasi_kerja = 2;
    } else {
        $nilai_prestasi_kerja = 1;
    }

    // Nilai Prestasi Individual
    if ($prestasi_individual > 1) {
        $nilai_prestasi_individual = 2;
    } else {
        $nilai_prestasi_individual = 1;
    }

    // Nilai Skema Nasional
    if ($skema_nasional > 1) {
        $nilai_skema_nasional = 2;
    } else {
        $nilai_skema_nasional = 1;
    }

    // Nilai Sertifikasi Guru
    $nilai_sertifikasi_guru = ($sertifikasi_guru == 1) ? 2 : 1;

    // Bobot untuk setiap kriteria
    $bobot_absensi = 0.30;
    $bobot_prestasi_kerja = 0.25;
    $bobot_prestasi_individual = 0.25;
    $bobot_skema_nasional = 0.10;
    $bobot_sertifikasi_guru = 0.10;

    // Hitung nilai total berdasarkan perhitungan SAW
    $nilai_total = ($nilai_absensi * $bobot_absensi) +
                   ($nilai_prestasi_kerja * $bobot_prestasi_kerja) +
                   ($nilai_prestasi_individual * $bobot_prestasi_individual) +
                   ($nilai_skema_nasional * $bobot_skema_nasional) +
                   ($nilai_sertifikasi_guru * $bobot_sertifikasi_guru);

    // Simpan data guru ke dalam database termasuk nilai total
    $sql = "INSERT INTO guru (nama_guru, absensi, prestasi_kerja, prestasi_individual, skema_nasional, sertifikasi_guru, nilai_total) 
            VALUES ('$nama_guru', '$absensi', '$prestasi_kerja', '$prestasi_individual', '$skema_nasional', '$sertifikasi_guru', '$nilai_total')";

    if ($conn->query($sql) === TRUE) {

        header('Location: guru_list.php?status=success'); // Redirect setelah berhasil
    } else {
        echo "Error: " . $conn->error;
    }
}
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
            <div class="card-header bg-warning text-dark">Input Data Guru</div>
            <div class="card-body">
                <form action="input_guru.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_guru" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="nama_guru" name="nama_guru" required>
                    </div>
                    <div class="mb-3">
                        <label for="absensi" class="form-label">Absensi (%)</label>
                        <input type="number" class="form-control" id="absensi" name="absensi" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestasi_kerja" class="form-label">Prestasi Kerja (Sertifikat Keahlian)</label>
                        <input type="number" class="form-control" id="prestasi_kerja" name="prestasi_kerja" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestasi_individual" class="form-label">Prestasi Individual (Sertifikat Lomba Antar Kabupaten)</label>
                        <input type="number" class="form-control" id="prestasi_individual" name="prestasi_individual" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="skema_nasional" class="form-label">Skema Nasional (Sertifikat Lomba Nasional)</label>
                        <input type="number" class="form-control" id="skema_nasional" name="skema_nasional" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikasi_guru" class="form-label">Sertifikasi Guru</label>
                        <select class="form-select" id="sertifikasi_guru" name="sertifikasi_guru" required>
                            <option value="1">Punya Sertifikasi</option>
                            <option value="0">Tidak Punya Sertifikasi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Data Guru</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
