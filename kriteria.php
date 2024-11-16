<?php
include 'koneksi.php';

session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];

    $sql = "INSERT INTO kriteria (nama_kriteria, bobot) VALUES ('$nama_kriteria', '$bobot')";
    if ($conn->query($sql) === TRUE) {
        header('Location: kriteria.php?status=added');
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM kriteria WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: kriteria.php?status=deleted');
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
    <title>Data Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Data Kriteria</h4>
            </div>
            <div class="card-body">
                <form action="kriteria.php" method="POST" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" required>
                        </div>
                        <div class="col-md-4">
                            <label for="bobot" class="form-label">Bobot (%)</label>
                            <input type="number" class="form-control" id="bobot" name="bobot" min="0" max="100" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">Tambah</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot (%)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM kriteria";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_kriteria']}</td>
                                    <td>{$row['bobot']}%</td>
                                    <td>
                                        <a href='edit_kriteria.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='kriteria.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>Data tidak tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
