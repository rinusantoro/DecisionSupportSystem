<?php include 'koneksi.php'; 
session_start();

// Jika pengguna tidak login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navigasi.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">Laporan Penilaian Guru</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "
                            SELECT g.nama_guru, p.nilai_akhir
                            FROM penilaian p
                            JOIN guru g ON p.guru_id = g.id
                            ORDER BY p.nilai_akhir DESC
                        ";
                        $result = $conn->query($sql);
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_guru']}</td>
                                    <td>{$row['nilai_akhir']}</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>Data tidak tersedia</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
