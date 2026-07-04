<?php
require_once "includes/functions.php";
include "includes/header.php";
?>

<?php if (isset($_GET['sukses'])): ?>
    <div class="alert alert-success">
        Pendaftaran berhasil disimpan. Jadwal kedatangan otomatis:
        <b><?php echo htmlspecialchars($_GET['hari']); ?>, <?php echo htmlspecialchars($_GET['tanggal']); ?> jam <?php echo htmlspecialchars($_GET['jam']); ?></b>
    </div>
<?php endif; ?>

<h3 class="section-title">Input Pendaftaran</h3>
<div class="info-box">
    Kapasitas layanan: <b>5 orang/hari</b>. Jika hari yang tersedia sudah penuh, sistem otomatis menjadwalkan ke hari berikutnya. Hari Minggu libur.
</div>

<form class="form-box" action="daftar_proses.php" method="post">
    <div class="row">
        <label>Nama Pemohon</label>
        <input type="text" name="nama_pemohon" required>
    </div>
    <div class="row">
        <label>Tanggal Daftar</label>
        <input type="text" value="<?php echo date('Y-m-d'); ?>" readonly>
    </div>
    <div class="row">
        <label></label>
        <button type="submit" class="btn">Simpan</button>
    </div>
</form>

<h3 class="section-title">Data Pendaftar</h3>
<table>
    <tr>
        <th>No. Daftar</th>
        <th>Nama Pemohon</th>
        <th>Tgl Daftar</th>
        <th>Hari</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Action</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM pendaftaran ORDER BY no_daftar DESC");
    if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['no_daftar']; ?></td>
        <td><?php echo htmlspecialchars($row['nama_pemohon']); ?></td>
        <td><?php echo $row['tgl_daftar']; ?></td>
        <td><?php echo $row['hari']; ?></td>
        <td><?php echo $row['tanggal']; ?></td>
        <td><?php echo $row['jam']; ?></td>
        <td>
            <a class="action-link action-edit" href="daftar_edit.php?id=<?php echo $row['no_daftar']; ?>">edit</a>
            <a class="action-link action-hapus" href="daftar_hapus.php?id=<?php echo $row['no_daftar']; ?>"
               onclick="return confirm('Hapus data pendaftar ini?');">hapus</a>
        </td>
    </tr>
    <?php endwhile; else: ?>
    <tr><td colspan="7">Belum ada data pendaftar.</td></tr>
    <?php endif; ?>
</table>

<?php include "includes/footer.php"; ?>
