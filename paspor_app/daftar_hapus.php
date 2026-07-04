<?php
require_once "includes/functions.php";

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM pendaftaran WHERE no_daftar=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: daftar.php");
exit;
?>
