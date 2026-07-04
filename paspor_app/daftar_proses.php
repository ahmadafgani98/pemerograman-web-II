<?php
require_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemohon = trim($_POST['nama_pemohon']);
    $tgl_daftar   = date('Y-m-d');

    // cari jadwal otomatis sesuai kapasitas 5 orang/hari
    list($hari, $tanggal, $jam) = cari_jadwal($conn);

    $stmt = $conn->prepare("INSERT INTO pendaftaran (nama_pemohon, tgl_daftar, hari, tanggal, jam) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_pemohon, $tgl_daftar, $hari, $tanggal, $jam);
    $stmt->execute();

    header("Location: daftar.php?sukses=1&hari=" . urlencode($hari) . "&tanggal=" . urlencode($tanggal) . "&jam=" . urlencode($jam));
    exit;
}
?>
