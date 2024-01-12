<?php
// Sertakan file koneksi.php
require_once "../koneksi.php";

// Tangkap id_kebutuhan dari permintaan POST
$id_kebutuhan = $_POST['id_kebutuhan'];

// Query untuk mendapatkan informasi kebutuhan sampah
$query = "SELECT ks.jenis_sampah, ks.jumlah_sampah, ks.satuan_sampah, ks.tanggal_kebutuhan, pp.nama_pabrik
          FROM kebutuhan_sampah ks
          JOIN pabrik_paving pp ON ks.id_pabrik = pp.id_pabrik
          WHERE ks.id_kebutuhan = '$id_kebutuhan'";

$result = mysqli_query($koneksi, $query);

// Siapkan data yang akan dikirim sebagai respons
$response = array();

if ($row = mysqli_fetch_assoc($result)) {
    $response['jenis_sampah'] = $row['jenis_sampah'];
    $response['jumlah_sampah'] = $row['jumlah_sampah'];
    $response['satuan_sampah'] = $row['satuan_sampah'];
    $response['tanggal_kebutuhan'] = $row['tanggal_kebutuhan'];
    $response['nama_pabrik'] = $row['nama_pabrik'];
}

// Mengembalikan data dalam format JSON
echo json_encode($response);

// Tutup koneksi
mysqli_close($koneksi);
?>
