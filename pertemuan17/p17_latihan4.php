<?php
// PERBAIKAN 1: Menggunakan mysqli_connect agar mendukung PHP versi baru
// PERBAIKAN 2: Menggunakan parameter default XAMPP agar tidak "Access Denied" [cite: 176, 181]
$host     = "localhost";
$username = "root";
$password = ""; 
$database = "pemrograman_web2";

$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa status koneksi database
if (!$koneksi) {
    // Jika gagal, tampilkan pesan kesalahannya
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

echo "Koneksi database berhasil terhubung!";
?>