<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Tampilkan data kebutuhan sampah yang perlu diverifikasi
$query = "SELECT * FROM kebutuhan_sampah WHERE status_kebutuhan = 'menunggu verifikasi'";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kebutuhan Sampah</title>
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
                                Verification
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
                    <h1 class="h2">Verifikasi Kebutuhan Sampah</h1>
                </div>

                <!-- Tampilkan data dalam bentuk card -->
                <div class="container">
                    <div class="row">

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['jenis_sampah'] . '</h5>
                                        <p class="card-text">Jumlah: ' . $row['jumlah_sampah'] . ' ' . $row['satuan_sampah'] . '</p>
                                        <p class="card-text">Tanggal Kebutuhan: ' . $row['tanggal_kebutuhan'] . '</p>
                                        <form action="proses_verifikasi.php" method="post">
                                            <input type="hidden" name="id_kebutuhan" value="' . $row['id_kebutuhan'] . '">
                                            <button type="submit" name="setujui" class="btn btn-success">Disetujui</button>
                                            <button type="submit" name="tolak" class="btn btn-danger">Ditolak</button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
