<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Ambil ID penjualan dari parameter URL
$id_penjualan = isset($_GET['id_penjualan']) ? $_GET['id_penjualan'] : die('ID Penjualan tidak ditemukan.');

// Query untuk mengambil data penjualan_sampah dan penjual_sampah berdasarkan ID penjualan
$query = "SELECT penjualan_sampah.*, penjual_sampah.nama_penjual FROM penjualan_sampah
          JOIN penjual_sampah ON penjualan_sampah.id_penjual = penjual_sampah.id_penjual
          WHERE penjualan_sampah.id_penjualan = $id_penjualan";

$result = mysqli_query($koneksi, $query);

// Cek apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_penjual = $row['nama_penjual'];
    $jumlah_sampah = $row['jumlah_sampah'];
    $satuan_sampah = $row['satuan_sampah'];
    $tanggal_penjualan = $row['tanggal_penjualan'];
    $status_penjualan = $row['status_penjualan'];
    $foto_sampah = $row['foto_sampah'];
} else {
    // Redirect atau tampilkan pesan kesalahan jika data tidak ditemukan
    header("Location: error.php");
    exit();
}

// Tombol "Disetujui" atau "Ditolak" diklik
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sesuaikan query update status_penjualan sesuai kebutuhan
    $status_update = ($_POST['action'] == 'disetujui') ? 'disetujui' : 'ditolak';
    $updateQuery = "UPDATE penjualan_sampah SET status_penjualan = '$status_update' WHERE id_penjualan = $id_penjualan";

    if (mysqli_query($koneksi, $updateQuery)) {
        $status_penjualan = $status_update;

        // Tambahkan data ke tabel laporan_penjualan_sampah
        $queryLaporan = "INSERT INTO laporan_penjualan_sampah (id_pabrik, id_penjualan, tanggal_laporan, total_penjualan) VALUES (1, $id_penjualan, NOW(), $jumlah_sampah)";
        mysqli_query($koneksi, $queryLaporan);
    } else {
        // Tampilkan pesan kesalahan jika query tidak berhasil
        echo '<div class="alert alert-danger" role="alert">Gagal mengupdate status penjualan.</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan Sampah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h1 class="mt-4">Detail Penjualan Sampah</h1>
        <hr>

        <!-- Tampilkan informasi penjualan -->
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $foto_sampah; ?>" alt="Foto Sampah" style="max-width: 100%;">
            </div>
            <div class="col-md-6">
                <h3><?php echo $nama_penjual; ?></h3>
                <p>Jumlah: <?php echo $jumlah_sampah . ' ' . $satuan_sampah; ?></p>
                <p>Tanggal Penjualan: <?php echo $tanggal_penjualan; ?></p>
                <p>Status Penjualan: <?php echo $status_penjualan; ?></p>
            </div>
        </div>

        <!-- Tampilkan informasi penjual -->
        <div class="mt-4">
            <h2>Informasi Penjual</h2>
            <?php
            // Query untuk mendapatkan informasi penjual berdasarkan id_penjual pada data penjualan
            $queryPenjual = "SELECT * FROM penjual_sampah WHERE id_penjual = {$row['id_penjual']}";
            $resultPenjual = mysqli_query($koneksi, $queryPenjual);

            if ($rowPenjual = mysqli_fetch_assoc($resultPenjual)) {
                echo '<p>Nama Penjual: ' . $rowPenjual['nama_penjual'] . '</p>';
                echo '<p>Alamat Penjual: ' . $rowPenjual['alamat_penjual'] . '</p>';
                echo '<p>Email Penjual: ' . $rowPenjual['email_penjual'] . '</p>';
                echo '<p>Telepon Penjual: ' . $rowPenjual['telepon_penjual'] . '</p>';
            } else {
                echo '<p>Informasi penjual tidak ditemukan.</p>';
            }
            ?>
        </div>

        <!-- Tombol Disetujui dan Ditolak -->
        <?php if ($status_penjualan == 'menunggu verifikasi') : ?>
            <form method="post" class="mt-4">
                <button type="submit" name="action" value="disetujui" class="btn btn-success">Disetujui</button>
                <button type="submit" name="action" value="ditolak" class="btn btn-danger">Ditolak</button>
            </form>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>