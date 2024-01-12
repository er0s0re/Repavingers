<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    require_once "koneksi.php"; // Ubah ini sesuai dengan file koneksi Anda

    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $email = $_POST["email"];
    $telepon = $_POST["telepon"];
    $password = $_POST["password"];

    // Validasi data
    if (empty($nama) || empty($alamat) || empty($email) || empty($telepon) || empty($password)) {
        // Jika ada input yang kosong, tampilkan pesan error atau lakukan tindakan yang sesuai
        echo "Harap isi semua kolom.";
        exit();
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Jika email tidak valid, tampilkan pesan error atau lakukan tindakan yang sesuai
        echo "Format email tidak valid.";
        exit();
    }

    // Query untuk menambahkan data penjual sampah ke tabel penjual_sampah
    $query = "INSERT INTO penjual_sampah (nama_penjual, alamat_penjual, email_penjual, telepon_penjual, password_penjual) VALUES ('$nama', '$alamat', '$email', '$telepon', '$password')";

    if (mysqli_query($koneksi, $query)) {
        // Registrasi berhasil, arahkan pengguna ke halaman login
        header("Location: index.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error atau sesuaikan tindakan yang diperlukan
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}
?>
