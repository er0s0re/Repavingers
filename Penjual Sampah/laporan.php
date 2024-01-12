<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Ambil data penjualan sampah berdasarkan id_penjual
$id_penjual = $_SESSION['user_id'];
$query_penjualan = "SELECT ps.id_penjualan, pp.nama_pabrik, ks.jenis_sampah, ps.jumlah_sampah, ps.satuan_sampah, ps.tanggal_penjualan, ps.status_penjualan
                    FROM penjualan_sampah ps
                    JOIN kebutuhan_sampah ks ON ps.id_kebutuhan = ks.id_kebutuhan
                    JOIN pabrik_paving pp ON ks.id_pabrik = pp.id_pabrik
                    WHERE ps.id_penjual = '$id_penjual'";
$result_penjualan = mysqli_query($koneksi, $query_penjualan);

// Ambil data laporan penjualan sampah berdasarkan id_penjual
$query_laporan = "SELECT * FROM laporan_penjualan_sampah WHERE id_penjualan = '$id_penjual'";
$result_laporan = mysqli_query($koneksi, $query_laporan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Sampah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="penjualan.php">
                                Penjualan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="laporan.php">
                                Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Laporan Penjualan Sampah</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- Tombol atau elemen lainnya yang ingin Anda tambahkan di atas -->
                    </div>
                </div>

                <!-- Tabel Penjualan Sampah -->
                <div class="container">
                    <h2>Penjualan Sampah</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Penjualan</th>
                                <th>Nama Pabrik</th>
                                <th>Jenis Sampah</th>
                                <th>Jumlah Sampah</th>
                                <th>Satuan Sampah</th>
                                <th>Tanggal Penjualan</th>
                                <th>Status Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row_penjualan = mysqli_fetch_assoc($result_penjualan)) {
                                echo '<tr>
                                        <td>' . $row_penjualan['id_penjualan'] . '</td>
                                        <td>' . $row_penjualan['nama_pabrik'] . '</td>
                                        <td>' . $row_penjualan['jenis_sampah'] . '</td>
                                        <td>' . $row_penjualan['jumlah_sampah'] . '</td>
                                        <td>' . $row_penjualan['satuan_sampah'] . '</td>
                                        <td>' . $row_penjualan['tanggal_penjualan'] . '</td>
                                        <td>' . $row_penjualan['status_penjualan'] . '</td>
                                      </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Laporan Penjualan Sampah -->
                <div class="container mt-4">
                    <h2>Laporan Penjualan Sampah</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Laporan</th>
                                <th>Tanggal Laporan</th>
                                <th>Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row_laporan = mysqli_fetch_assoc($result_laporan)) {
                                echo '<tr>
                                        <td>' . $row_laporan['id_laporan'] . '</td>
                                        <td>' . $row_laporan['tanggal_laporan'] . '</td>
                                        <td>' . $row_laporan['total_penjualan'] . '</td>
                                      </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
