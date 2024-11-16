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
    // Ambil data nilai kriteria berdasarkan ID
    $sql = "SELECT * FROM nilai_kriteria WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $nilai_kriteria = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id_kriteria = $_POST['id_kriteria'];
    $interval = $_POST['interval'];
    $keterangan = $_POST['keterangan'];
    $nilai = $_POST['nilai'];

    // Update data nilai kriteria
    $sql = "UPDATE nilai_kriteria SET 
                id_kriteria = '$id_kriteria',
                range_interval = '$interval',
                keterangan = '$keterangan',
                nilai = '$nilai'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: nilai_kriteria.php?status=updated'); // Redirect ke halaman nilai kriteria setelah update
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
    <title>Update Nilai Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">Update Nilai Kriteria</div>
            <div class="card-body">
                <form action="update_nilai_kriteria.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $nilai_kriteria['id']; ?>">
                    <div class="mb-3">
                        <label for="id_kriteria" class="form-label">Kriteria</label>
                        <select class="form-select" id="id_kriteria" name="id_kriteria" required>
                            <option value="" disabled selected>Pilih Kriteria</option>
                            <?php
                            $sql = "SELECT * FROM kriteria";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($nilai_kriteria['id_kriteria'] == $row['id']) ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['nama_kriteria']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="interval" class="form-label">Interval (%)</label>
                        <input type="text" class="form-control" id="interval" name="interval" value="<?php echo $nilai_kriteria['range_interval']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $nilai_kriteria['keterangan']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input type="number" class="form-control" id="nilai" name="nilai" min="1" max="3" value="<?php echo $nilai_kriteria['nilai']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
