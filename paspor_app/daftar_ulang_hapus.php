<?php
require_once "includes/functions.php";

$id = intval($_GET['id']);

// ambil no_antrian terkait (jika ada) untuk sekalian hapus dari tabel pengurusan
$stmt = $conn->prepare("SELECT no_antrian FROM daftar_ulang WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($data && $data['no_antrian']) {
    $stmt2 = $conn->prepare("DELETE FROM pengurusan WHERE no_antrian=?");
    $stmt2->bind_param("s", $data['no_antrian']);
    $stmt2->execute();
}

$stmt = $conn->prepare("DELETE FROM daftar_ulang WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: daftar_ulang.php");
exit;
?>
