<?php
// Sertakan file koneksi.php
require_once "../koneksi.php";

// Inisialisasi variabel untuk menyimpan respon
$response = array();

// Periksa apakah `id_kebutuhan` dikirimkan melalui metode POST
if (isset($_POST['id_kebutuhan'])) {
    // Ambil `id_kebutuhan` dari data POST
    $id_kebutuhan = $_POST['id_kebutuhan'];

    // Query untuk mendapatkan informasi jenis sampah berdasarkan `id_kebutuhan`
    $query = "SELECT jenis_sampah, jumlah_sampah, satuan_sampah, tanggal_kebutuhan FROM kebutuhan_sampah WHERE id_kebutuhan = ?";

    // Eksekusi query
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_kebutuhan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Periksa apakah data ditemukan
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind hasil query ke variabel
        mysqli_stmt_bind_result($stmt, $jenis_sampah, $jumlah_sampah, $satuan_sampah, $tanggal_kebutuhan);

        // Ambil nilai hasil query
        mysqli_stmt_fetch($stmt);

        // Isi respon dengan informasi jenis sampah
        $response['jenis_sampah'] = $jenis_sampah;
        $response['jumlah_sampah'] = $jumlah_sampah;
        $response['satuan_sampah'] = $satuan_sampah;
        $response['tanggal_kebutuhan'] = $tanggal_kebutuhan;

        // Tutup prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika data tidak ditemukan
        $response['error'] = true;
        $response['message'] = "Tidak ada kebutuhan sampah yang tersedia untuk jenis sampah ini.";
    }
} else {
    // Jika `id_kebutuhan` tidak dikirimkan
    $response['error'] = true;
    $response['message'] = "Parameter id_kebutuhan tidak ditemukan.";
}

// Mengubah respon menjadi format JSON
echo json_encode($response);
?>
