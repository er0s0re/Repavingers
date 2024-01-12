<?php
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Hapus sesi secara menyeluruh
session_destroy();

// Redirect ke halaman login atau halaman lain yang diinginkan setelah logout
header("Location: index.php");
exit();
?>
