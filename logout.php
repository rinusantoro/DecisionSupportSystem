<?php
session_start(); // Memulai session
session_unset(); // Menghapus semua data session
session_destroy(); // Menghancurkan session

// Arahkan kembali ke halaman login
header('Location: login.php');
exit();
?>
