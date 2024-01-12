<?php
$host = "localhost"; // Ganti dengan nama host database Anda
$user = "username"; // Ganti dengan nama pengguna database Anda
$password = "password"; // Ganti dengan kata sandi database Anda
$database = "repavingers"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
