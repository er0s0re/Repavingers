<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Inisialisasi variabel untuk pesan kesalahan
$error = "";

// Ambil data kebutuhan sampah dari database
$query_kebutuhan = "SELECT ks.id_kebutuhan, ks.jenis_sampah, ks.jumlah_sampah, ks.satuan_sampah, ks.tanggal_kebutuhan, pp.nama_pabrik
                    FROM kebutuhan_sampah ks
                    JOIN pabrik_paving pp ON ks.id_pabrik = pp.id_pabrik
                    WHERE ks.status_kebutuhan = 'disetujui'";
$result_kebutuhan = mysqli_query($koneksi, $query_kebutuhan);

// Proses saat formulir dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $id_penjual = $_SESSION['user_id']; // Menggunakan ID penjual dari sesi
    $id_kebutuhan = $_POST['id_kebutuhan']; // Sesuaikan dengan nama input di formulir
    $jumlah_sampah = $_POST['jumlah_sampah'];
    $satuan_sampah = $_POST['satuan_sampah'];
    $tanggal_penjualan = $_POST['tanggal_penjualan'];

    // Ambil informasi kebutuhan sampah yang dipilih dari hasil query
    $selected_kebutuhan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT ks.id_kebutuhan, ks.jenis_sampah, ks.jumlah_sampah, ks.satuan_sampah, ks.tanggal_kebutuhan, pp.nama_pabrik
                                                                  FROM kebutuhan_sampah ks
                                                                  JOIN pabrik_paving pp ON ks.id_pabrik = pp.id_pabrik
                                                                  WHERE ks.id_kebutuhan = '$id_kebutuhan'"));

    // Query untuk menyimpan data ke dalam tabel penjualan_sampah
    $query = "INSERT INTO penjualan_sampah (id_penjual, id_kebutuhan, jumlah_sampah, satuan_sampah, tanggal_penjualan, status_penjualan, foto_sampah) 
              VALUES ('$id_penjual', '$id_kebutuhan', '$jumlah_sampah', '$satuan_sampah', '$tanggal_penjualan', 'menunggu verifikasi', '')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman lain jika berhasil
        header("Location: index.php");
        exit();
    } else {
        // Jika query tidak berhasil, tangkap pesan kesalahan
        $error = "Error: " . mysqli_error($koneksi);
    }

    // Tutup koneksi
    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penjualan Sampah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Tangani perubahan pada opsi kebutuhan sampah
            $('#id_kebutuhan').change(function () {
                // Ambil nilai id_kebutuhan yang dipilih
                var selectedId = $(this).val();

                // Kirim permintaan AJAX untuk mendapatkan informasi kebutuhan sampah
                $.ajax({
                    url: 'get_kebutuhan_info.php', // Ganti dengan nama file yang sesuai
                    method: 'POST',
                    data: { id_kebutuhan: selectedId },
                    dataType: 'json',
                    success: function (response) {
                        // Isi nilai pada textarea informasi_kebutuhan
                        $('#informasi_kebutuhan').val(
                            'Nama Pabrik: ' + response.nama_pabrik +
                            '\nJenis Sampah: ' + response.jenis_sampah +
                            '\nJumlah Sampah: ' + response.jumlah_sampah + ' ' + response.satuan_sampah +
                            '\nTanggal Kebutuhan: ' + response.tanggal_kebutuhan
                        );
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
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
                            <a class="nav-link active" href="penjualan.php">
                                Penjualan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="laporan.php">
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
                    <h1 class="h2">Form Penjualan Sampah</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- Tombol atau elemen lainnya yang ingin Anda tambahkan di atas -->
                    </div>
                </div>

                <!-- Isi formulir penjualan -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 mt-5">
                            <form action="" method="post">

                                <div class="mb-3">
                                    <label for="id_kebutuhan" class="form-label">Pilih Kebutuhan Sampah</label>
                                    <select class="form-select" id="id_kebutuhan" name="id_kebutuhan" required>
                                        <?php
                                        // Menampilkan opsi kebutuhan sampah
                                        while ($row_kebutuhan = mysqli_fetch_assoc($result_kebutuhan)) {
                                            echo '<option value="' . $row_kebutuhan['id_kebutuhan'] . '">' . $row_kebutuhan['jenis_sampah'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Menampilkan informasi yang dipilih -->
                                <div class="mb-3">
                                    <label for="informasi_kebutuhan" class="form-label">Informasi Kebutuhan Sampah yang Dipilih</label>
                                    <textarea class="form-control" id="informasi_kebutuhan" name="informasi_kebutuhan" rows="4" readonly></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_sampah" class="form-label">Jumlah Sampah</label>
                                    <input type="number" class="form-control" id="jumlah_sampah" name="jumlah_sampah" required>
                                </div>

                                <div class="mb-3">
                                    <label for="satuan_sampah" class="form-label">Satuan Sampah</label>
                                    <input type="text" class="form-control" id="satuan_sampah" name="satuan_sampah" required>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                                    <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                            <!-- Menampilkan pesan kesalahan jika ada -->
                            <?php if ($error != "") : ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
