<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data guru berdasarkan ID
    $sql = "SELECT * FROM guru WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $guru = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $absensi = $_POST['absensi'];
    $sertifikat_keahlian = $_POST['sertifikat_keahlian'];
    $sertifikat_individual = $_POST['sertifikat_individual'];
    $sertifikat_skema_nasional = $_POST['sertifikat_skema_nasional'];
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

    // Update data guru
    $sql = "UPDATE guru SET 
                nama_guru = '$nama',
                absensi = '$absensi',
                prestasi_kerja = '$sertifikat_keahlian',
                prestasi_individual = '$sertifikat_individual',
                skema_nasional = '$sertifikat_skema_nasional',
                sertifikasi_guru = '$sertifikasi_guru',
                nilai_total = '$nilai_total'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: guru_list.php?status=updated');
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
    <title>Edit Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">Edit Data Guru</div>
            <div class="card-body">
                <form action="edit_guru.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $guru['id']; ?>">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $guru['nama_guru']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="absensi" class="form-label">Absensi (%)</label>
                        <input type="number" class="form-control" id="absensi" name="absensi" min="0" max="100" value="<?php echo $guru['absensi']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikat_keahlian" class="form-label">Jumlah Sertifikat Keahlian</label>
                        <input type="number" class="form-control" id="sertifikat_keahlian" name="sertifikat_keahlian" value="<?php echo $guru['prestasi_kerja']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikat_individual" class="form-label">Jumlah Sertifikat Individual</label>
                        <input type="number" class="form-control" id="sertifikat_individual" name="sertifikat_individual" value="<?php echo $guru['prestasi_individual']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikat_skema_nasional" class="form-label">Jumlah Sertifikat Skema Nasional</label>
                        <input type="number" class="form-control" id="sertifikat_skema_nasional" name="sertifikat_skema_nasional" value="<?php echo $guru['skema_nasional']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikasi_guru" class="form-label">Sertifikasi Guru</label>
                        <select class="form-select" id="sertifikasi_guru" name="sertifikasi_guru" required>
                            <option value="1" <?php echo $guru['sertifikasi_guru'] == 1 ? 'selected' : ''; ?>>Ya</option>
                            <option value="0" <?php echo $guru['sertifikasi_guru'] == 0 ? 'selected' : ''; ?>>Tidak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
