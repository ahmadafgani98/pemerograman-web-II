<?php
// =========================================================
// KONEKSI DATABASE
// Sesuaikan host, username, password sesuai server MySQL Anda
// =========================================================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_paspor";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Nama-nama hari dalam Bahasa Indonesia
$nama_hari = [
    "Sunday"    => "Minggu",
    "Monday"    => "Senin",
    "Tuesday"   => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday"  => "Kamis",
    "Friday"    => "Jumat",
    "Saturday"  => "Sabtu",
];

function hari_indonesia($tanggal) {
    global $nama_hari;
    $namaHariEn = date("l", strtotime($tanggal));
    return $nama_hari[$namaHariEn];
}
?>
