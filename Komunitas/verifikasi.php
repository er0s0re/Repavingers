<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Ganti login.php dengan halaman login Anda
    exit();
}

// Sertakan file koneksi.php
require_once "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komunitas Verifikasi</title>
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
                            <a class="nav-link active" href="verifikasi.php">
                                Verifikasi
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
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Detail Penjualan Sampah</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- Tombol atau elemen lainnya yang ingin Anda tambahkan di atas -->
                    </div>
                </div>

                <!-- Isi dari halaman detail penjualan menggunakan PHP -->
                <div class="container">
                    <div class="row">

                        <?php
                        // Query untuk mengambil data dari tabel penjualan_sampah dan penjual_sampah dengan status_penjualan yang belum diverifikasi
                        $query = "SELECT penjualan_sampah.*, penjual_sampah.nama_penjual FROM penjualan_sampah
                                  JOIN penjual_sampah ON penjualan_sampah.id_penjual = penjual_sampah.id_penjual
                                  WHERE penjualan_sampah.status_penjualan = 'menunggu verifikasi'";
                        $result = mysqli_query($koneksi, $query);

                        // Tampilkan data dalam bentuk card
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Tampilkan data sesuai kebutuhan
                            echo '
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <!-- ... -->
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['nama_penjual'] . '</h5>
                                        <p class="card-text">Jumlah: ' . $row['jumlah_sampah'] . ' ' . $row['satuan_sampah'] . '</p>
                                        <p class="card-text">Tanggal Penjualan: ' . $row['tanggal_penjualan'] . '</p>
                                        <a href="detail_penjualan.php?id_penjualan=' . $row['id_penjualan'] . '" class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>';
                        }

                        // Tutup koneksi
                        mysqli_close($koneksi);
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>