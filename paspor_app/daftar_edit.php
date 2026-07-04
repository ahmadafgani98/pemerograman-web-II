<?php
require_once "includes/functions.php";

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemohon = trim($_POST['nama_pemohon']);
    $hari = trim($_POST['hari']);
    $tanggal = trim($_POST['tanggal']);
    $jam = trim($_POST['jam']);

    $stmt = $conn->prepare("UPDATE pendaftaran SET nama_pemohon=?, hari=?, tanggal=?, jam=? WHERE no_daftar=?");
    $stmt->bind_param("ssssi", $nama_pemohon, $hari, $tanggal, $jam, $id);
    $stmt->execute();

    header("Location: daftar.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE no_daftar=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: daftar.php");
    exit;
}

include "includes/header.php";
?>
<h3 class="section-title">Edit Data Pendaftar</h3>
<form class="form-box" method="post">
    <div class="row">
        <label>No. Daftar</label>
        <input type="text" value="<?php echo $data['no_daftar']; ?>" readonly>
    </div>
    <div class="row">
        <label>Nama Pemohon</label>
        <input type="text" name="nama_pemohon" value="<?php echo htmlspecialchars($data['nama_pemohon']); ?>" required>
    </div>
    <div class="row">
        <label>Hari</label>
        <input type="text" name="hari" value="<?php echo htmlspecialchars($data['hari']); ?>" required>
    </div>
    <div class="row">
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
    </div>
    <div class="row">
        <label>Jam</label>
        <input type="text" name="jam" value="<?php echo htmlspecialchars($data['jam']); ?>" required>
    </div>
    <div class="row">
        <label></label>
        <button type="submit" class="btn">Update</button>
        <a href="daftar.php" class="btn btn-danger" style="margin-left:8px;">Batal</a>
    </div>
</form>
<?php include "includes/footer.php"; ?>
