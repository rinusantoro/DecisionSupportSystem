<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kriteria = $_POST['id_kriteria'];
    $interval = $_POST['interval'];
    $keterangan = $_POST['keterangan'];
    $nilai = $_POST['nilai'];

    $sql = "INSERT INTO nilai_kriteria (id_kriteria, range_interval, keterangan, nilai) 
            VALUES ('$id_kriteria', '$interval', '$keterangan', '$nilai')";

    if ($conn->query($sql) === TRUE) {
        header('Location: nilai_kriteria.php?status=added');
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM nilai_kriteria WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: nilai_kriteria.php?status=deleted');
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
    <title>Nilai Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4>Nilai Kriteria</h4>
            </div>
            <div class="card-body">
                <form action="nilai_kriteria.php" method="POST" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="id_kriteria" class="form-label">Kriteria</label>
                            <select class="form-select" id="id_kriteria" name="id_kriteria" required>
                                <option value="" disabled selected>Pilih Kriteria</option>
                                <?php
                                $sql = "SELECT * FROM kriteria";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nama_kriteria']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="interval" class="form-label">Interval (%)</label>
                            <input type="text" class="form-control" id="interval" name="interval" placeholder="e.g., 95-100" required>
                        </div>
                        <div class="col-md-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                        <div class="col-md-2">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" id="nilai" name="nilai" min="1" max="3" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">Tambah</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kriteria</th>
                            <th>Interval (%)</th>
                            <th>Keterangan</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT nk.*, k.nama_kriteria 
                                FROM nilai_kriteria nk 
                                JOIN kriteria k ON nk.id_kriteria = k.id";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_kriteria']}</td>
                                    <td>{$row['range_interval']}</td>
                                    <td>{$row['keterangan']}</td>
                                    <td>{$row['nilai']}</td>
                                    <td>
                                        <a href='update_nilai_kriteria.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='nilai_kriteria.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Data tidak tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
