<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    require_once "koneksi.php"; // Ubah ini sesuai dengan file koneksi Anda

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query untuk mencari data pengguna di tabel admin
    $queryAdmin = "SELECT * FROM admin WHERE email_admin = '$email' AND password_admin = '$password'";
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);

    // Query untuk mencari data pengguna di tabel komunitas
    $queryKomunitas = "SELECT * FROM komunitas WHERE email_komunitas = '$email' AND password_komunitas = '$password'";
    $resultKomunitas = mysqli_query($koneksi, $queryKomunitas);

    // Query untuk mencari data pengguna di tabel pabrik_paving
    $queryPabrik = "SELECT * FROM pabrik_paving WHERE email_pabrik = '$email' AND password_pabrik = '$password'";
    $resultPabrik = mysqli_query($koneksi, $queryPabrik);

    // Query untuk mencari data pengguna di tabel penjual_sampah
    $queryPenjual = "SELECT * FROM penjual_sampah WHERE email_penjual = '$email' AND password_penjual = '$password'";
    $resultPenjual = mysqli_query($koneksi, $queryPenjual);

    // Cek hasil query dan arahkan pengguna ke direktori yang sesuai
    if ($resultAdmin && mysqli_num_rows($resultAdmin) > 0) {
        $row = mysqli_fetch_assoc($resultAdmin);
        $_SESSION["user_id"] = $row["id_admin"];
        header("Location: Admin/index.php");
        exit();
    } elseif ($resultKomunitas && mysqli_num_rows($resultKomunitas) > 0) {
        $row = mysqli_fetch_assoc($resultKomunitas);
        $_SESSION["user_id"] = $row["id_komunitas"];
        header("Location: Komunitas/index.php");
        exit();
    } elseif ($resultPabrik && mysqli_num_rows($resultPabrik) > 0) {
        $row = mysqli_fetch_assoc($resultPabrik);
        $_SESSION["user_id"] = $row["id_pabrik"];
        header("Location: Pabrik/index.php");
        exit();
    } elseif ($resultPenjual && mysqli_num_rows($resultPenjual) > 0) {
        $row = mysqli_fetch_assoc($resultPenjual);
        $_SESSION["user_id"] = $row["id_penjual"];
        header("Location: Penjual Sampah/index.php");
        exit();
    } else {
        // Jika tidak ada data yang cocok, maka tampilkan pesan error atau arahkan kembali ke halaman login
        header("Location: index.php");
        exit();
    }
}
?>
