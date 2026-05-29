<?php
session_start();

if (isset($_SESSION['login'])) {

    // menghapus session
    session_unset();
    session_destroy();

    echo "<h1>Anda sudah berhasil LOGOUT</h1>";
    echo "<h2>Klik <a href='session1.php'>di sini</a> untuk LOGIN kembali</h2>";
    echo "<h2>Anda sekarang tidak bisa masuk ke halaman
    <a href='session2.php'>session2.php</a> lagi</h2>";
}
?>