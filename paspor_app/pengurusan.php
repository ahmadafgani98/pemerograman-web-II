<?php
require_once "includes/functions.php";
include "includes/header.php";

$total = $conn->query("SELECT SUM(pembayaran) AS total FROM pengurusan WHERE status='Diterima'")->fetch_assoc();
$pendapatan = $total['total'] ?? 0;
?>

<h3 class="section-title">Data Pengurusan Paspor</h3>
<div class="info-box">
    Data di bawah ini otomatis terbentuk dari hasil <b>Daftar Ulang</b> yang berkasnya lengkap (mendapat No. Antrian).
    Jika KTP, KK, dan Ijazah/Akte semua "Ada" &rarr; Berkas = Lengkap, Status = Diterima, Pembayaran = Rp 355.000.
    Jika tidak lengkap &rarr; Status = Ditolak, Pembayaran = Rp 0.
</div>

<table>
    <tr>
        <th>No. Antrian</th>
        <th>No. Daftar</th>
        <th>Nama Pemohon</th>
        <th>Berkas</th>
        <th>Status</th>
        <th>Keterangan</th>
        <th>Pembayaran</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM pengurusan ORDER BY created_at DESC");
    if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['no_antrian']; ?></td>
        <td><?php echo $row['no_daftar']; ?></td>
        <td><?php echo htmlspecialchars($row['nama_pemohon']); ?></td>
        <td><?php echo $row['berkas']; ?></td>
        <td class="<?php echo $row['status']=='Diterima' ? 'badge-ok' : 'badge-tidak'; ?>"><?php echo $row['status']; ?></td>
        <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
        <td>Rp <?php echo number_format($row['pembayaran'], 0, ',', '.'); ?></td>
    </tr>
    <?php endwhile; else: ?>
    <tr><td colspan="7">Belum ada data pengurusan.</td></tr>
    <?php endif; ?>
</table>

<div class="pendapatan-box">
    Total Pendapatan: Rp <?php echo number_format($pendapatan, 0, ',', '.'); ?>
</div>

<?php include "includes/footer.php"; ?>
