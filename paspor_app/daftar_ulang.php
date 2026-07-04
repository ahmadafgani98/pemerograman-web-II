<?php
require_once "includes/functions.php";
include "includes/header.php";

$selected = null;
if (isset($_GET['no_daftar']) && $_GET['no_daftar'] !== '') {
    $stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE no_daftar=?");
    $stmt->bind_param("i", $_GET['no_daftar']);
    $stmt->execute();
    $selected = $stmt->get_result()->fetch_assoc();
}
?>

<?php if (isset($_GET['sukses'])): ?>
    <div class="alert <?php echo $_GET['keterangan']=='OK' ? 'alert-success' : 'alert-error'; ?>">
        Data daftar ulang disimpan. Keterangan: <b><?php echo htmlspecialchars($_GET['keterangan']); ?></b>
        <?php if ($_GET['keterangan']=='OK'): ?>
            &mdash; No. Antrian: <b><?php echo htmlspecialchars($_GET['no_antrian']); ?></b>
        <?php endif; ?>
    </div>
<?php endif; ?>

<h3 class="section-title">Input Daftar Ulang</h3>

<!-- Langkah 1: pilih No. Daftar -->
<form class="form-box" method="get" style="margin-bottom:0;">
    <div class="row">
        <label>No. Daftar</label>
        <select name="no_daftar" onchange="this.form.submit()">
            <option value="">-- pilih no. daftar --</option>
            <?php
            $list = $conn->query("SELECT no_daftar, nama_pemohon FROM pendaftaran ORDER BY no_daftar DESC");
            while ($r = $list->fetch_assoc()):
                $sel = (isset($_GET['no_daftar']) && $_GET['no_daftar'] == $r['no_daftar']) ? "selected" : "";
            ?>
                <option value="<?php echo $r['no_daftar']; ?>" <?php echo $sel; ?>>
                    <?php echo $r['no_daftar'] . " - " . htmlspecialchars($r['nama_pemohon']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
</form>

<?php if ($selected): ?>
<form class="form-box" action="daftar_ulang_proses.php" method="post">
    <input type="hidden" name="no_daftar" value="<?php echo $selected['no_daftar']; ?>">
    <input type="hidden" name="hari_harus_datang" value="<?php echo $selected['hari']; ?>">
    <input type="hidden" name="tgl_harus_datang" value="<?php echo $selected['tanggal']; ?>">

    <div class="row">
        <label>Nama Pemohon</label>
        <span class="readonly-box"><?php echo htmlspecialchars($selected['nama_pemohon']); ?></span>
    </div>
    <div class="row">
        <label>Hari Harus Datang</label>
        <span class="readonly-box"><?php echo $selected['hari']; ?></span>
    </div>
    <div class="row">
        <label>Tgl Harus Datang</label>
        <span class="readonly-box"><?php echo $selected['tanggal']; ?></span>
    </div>
    <div class="row">
        <label>Hari Datang</label>
        <select name="hari_datang" required>
            <option value="">-- pilih --</option>
            <?php foreach (["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"] as $h): ?>
                <option value="<?php echo $h; ?>"><?php echo $h; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="row">
        <label>Tgl Datang</label>
        <input type="date" name="tgl_datang" required>
    </div>
    <div class="row">
        <label>Berkas</label>
        <label style="width:auto; margin-right:15px;"><input type="checkbox" name="ktp" value="Ada"> KTP</label>
        <label style="width:auto; margin-right:15px;"><input type="checkbox" name="kk" value="Ada"> KK</label>
        <label style="width:auto;"><input type="checkbox" name="ijazah_akte" value="Ada"> Ijazah/Akte</label>
    </div>
    <div class="row">
        <label>Keperluan</label>
        <select name="keperluan" required>
            <option value="Paspor Baru">Paspor Baru</option>
            <option value="Perpanjangan Paspor">Perpanjangan Paspor</option>
            <option value="Penggantian Paspor Rusak/Hilang">Penggantian Paspor Rusak/Hilang</option>
        </select>
    </div>
    <div class="row">
        <label></label>
        <button type="submit" class="btn">Simpan</button>
    </div>
</form>
<?php endif; ?>

<h3 class="section-title">Data Pendaftar Ulang</h3>
<table>
    <tr>
        <th>No. Daftar</th>
        <th>Nama Pemohon</th>
        <th>Keperluan</th>
        <th>KTP</th>
        <th>KK</th>
        <th>Ijazah/Akte</th>
        <th>Keterangan</th>
        <th>No. Antrian</th>
        <th>Action</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM daftar_ulang ORDER BY id DESC");
    if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['no_daftar']; ?></td>
        <td><?php echo htmlspecialchars($row['nama_pemohon']); ?></td>
        <td><?php echo htmlspecialchars($row['keperluan']); ?></td>
        <td><?php echo $row['ktp']; ?></td>
        <td><?php echo $row['kk']; ?></td>
        <td><?php echo $row['ijazah_akte']; ?></td>
        <td class="<?php echo $row['keterangan']=='OK' ? 'badge-ok' : 'badge-tidak'; ?>"><?php echo $row['keterangan']; ?></td>
        <td><?php echo $row['no_antrian'] ?: '-'; ?></td>
        <td>
            <a class="action-link action-hapus" href="daftar_ulang_hapus.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Hapus data ini?');">hapus</a>
        </td>
    </tr>
    <?php endwhile; else: ?>
    <tr><td colspan="9">Belum ada data.</td></tr>
    <?php endif; ?>
</table>

<?php include "includes/footer.php"; ?>
