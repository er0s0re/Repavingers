<?php
session_start();

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Proses form jika ada pengiriman data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $jenis_sampah = $_POST['jenis_sampah'];
    $jumlah_sampah = $_POST['jumlah_sampah'];
    $satuan_sampah = $_POST['satuan_sampah'];
    $tanggal_kebutuhan = $_POST['tanggal_kebutuhan'];

    // Periksa apakah kunci "id_pabrik" telah diatur dalam sesi
    $id_pabrik = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Pastikan id_pabrik yang diambil dari sesi valid
    if ($id_pabrik !== null) {
        // Id_pabrik valid, jalankan query untuk menyimpan data kebutuhan_sampah
        $query = "INSERT INTO kebutuhan_sampah (id_pabrik, jenis_sampah, jumlah_sampah, satuan_sampah, tanggal_kebutuhan) 
                  VALUES ('$id_pabrik', '$jenis_sampah', '$jumlah_sampah', '$satuan_sampah', '$tanggal_kebutuhan')";

        // Eksekusi query
        if (mysqli_query($koneksi, $query)) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Id_pabrik tidak valid
        echo "Error: Id_pabrik tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pabrik Dashboard</title>
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
                            <a class="nav-link active" href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pesanan.php">
                                Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- Tombol atau elemen lainnya yang ingin Anda tambahkan di atas -->
                    </div>
                </div>

                <!-- Formulir untuk mengisi tabel kebutuhan_sampah -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="jenis_sampah" class="form-label">Jenis Sampah</label>
                                    <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" required>
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
                                    <label for="tanggal_kebutuhan" class="form-label">Tanggal Kebutuhan</label>
                                    <input type="date" class="form-control" id="tanggal_kebutuhan" name="tanggal_kebutuhan" required>
                                </div>
                                <!-- Input id_pabrik diambil dari sesi -->
                                <input type="hidden" name="id_pabrik" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
