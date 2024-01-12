<?php
session_start();

// Sertakan file koneksi.php
require_once "../koneksi.php";

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $id_kebutuhan = $_POST["id_kebutuhan"];
    $action = isset($_POST["setujui"]) ? "setujui" : (isset($_POST["tolak"]) ? "tolak" : "");

    // Lakukan proses verifikasi berdasarkan aksi yang dipilih
    if ($action == "setujui") {
        // Lakukan tindakan setujui (misalnya, update status_kebutuhan menjadi 'disetujui')
        $updateQuery = "UPDATE kebutuhan_sampah SET status_kebutuhan = 'disetujui' WHERE id_kebutuhan = $id_kebutuhan";
        mysqli_query($koneksi, $updateQuery);
    } elseif ($action == "tolak") {
        // Lakukan tindakan tolak (misalnya, update status_kebutuhan menjadi 'ditolak')
        $updateQuery = "UPDATE kebutuhan_sampah SET status_kebutuhan = 'ditolak' WHERE id_kebutuhan = $id_kebutuhan";
        mysqli_query($koneksi, $updateQuery);
    }
}

// Redirect kembali ke halaman verifikasi.php setelah proses verifikasi selesai
header("Location: verifikasi.php");
exit();
?>
