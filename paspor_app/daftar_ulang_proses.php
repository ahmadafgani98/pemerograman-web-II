<?php
require_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_daftar        = intval($_POST['no_daftar']);
    $hari_harus       = trim($_POST['hari_harus_datang']);
    $tgl_harus        = trim($_POST['tgl_harus_datang']);
    $hari_datang      = trim($_POST['hari_datang']);
    $tgl_datang       = trim($_POST['tgl_datang']);
    $ktp              = isset($_POST['ktp']) ? 'Ada' : 'Tidak';
    $kk               = isset($_POST['kk']) ? 'Ada' : 'Tidak';
    $ijazah_akte      = isset($_POST['ijazah_akte']) ? 'Ada' : 'Tidak';
    $keperluan        = trim($_POST['keperluan']);

    // ambil nama pemohon dari tabel pendaftaran
    $stmt = $conn->prepare("SELECT nama_pemohon FROM pendaftaran WHERE no_daftar=?");
    $stmt->bind_param("i", $no_daftar);
    $stmt->execute();
    $pemohon = $stmt->get_result()->fetch_assoc();
    $nama_pemohon = $pemohon['nama_pemohon'];

    // tentukan keterangan (OK / Tidak)
    $keterangan = cek_keterangan($ktp, $kk, $ijazah_akte, $hari_datang, $tgl_datang, $hari_harus, $tgl_harus);

    // jika OK, generate no antrian otomatis
    $no_antrian = null;
    if ($keterangan === 'OK') {
        $no_antrian = generate_no_antrian($conn, $tgl_datang);
    }

    $stmt = $conn->prepare("
        INSERT INTO daftar_ulang
        (no_daftar, nama_pemohon, keperluan, hari_harus_datang, tgl_harus_datang, hari_datang, tgl_datang, ktp, kk, ijazah_akte, keterangan, no_antrian)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
    ");
    $stmt->bind_param(
        "isssssssssss",
        $no_daftar, $nama_pemohon, $keperluan, $hari_harus, $tgl_harus,
        $hari_datang, $tgl_datang, $ktp, $kk, $ijazah_akte, $keterangan, $no_antrian
    );
    $stmt->execute();

    // jika keterangan OK, langsung buat/perbarui data di tabel pengurusan
    if ($keterangan === 'OK') {
        proses_pengurusan($conn, $no_antrian, $no_daftar, $nama_pemohon, $ktp, $kk, $ijazah_akte);
    }

    header("Location: daftar_ulang.php?sukses=1&keterangan=" . urlencode($keterangan) . "&no_antrian=" . urlencode($no_antrian ?? ''));
    exit;
}
?>
