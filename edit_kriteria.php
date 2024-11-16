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
    $sql = "SELECT * FROM kriteria WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $kriteria = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];

    $sql = "UPDATE kriteria SET 
                nama_kriteria = '$nama_kriteria',
                bobot = '$bobot'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: kriteria.php?status=updated');
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
    <title>Edit Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">Edit Kriteria</div>
            <div class="card-body">
                <form action="edit_kriteria.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $kriteria['id']; ?>">
                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" value="<?php echo $kriteria['nama_kriteria']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot (%)</label>
                        <input type="number" class="form-control" id="bobot" name="bobot" min="0" max="100" value="<?php echo $kriteria['bobot']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
