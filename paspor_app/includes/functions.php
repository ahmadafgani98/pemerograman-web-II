<?php
require_once __DIR__ . "/config.php";

// Jam layanan per hari, kapasitas = jumlah slot = 5 orang/hari
$JAM_SLOT = ["08:00", "09:00", "10:00", "11:00", "13:00"];

/**
 * Mencari jadwal (hari, tanggal, jam) untuk pendaftar baru.
 * Aturan:
 * - Kapasitas 1 hari = 5 orang (5 slot jam)
 * - Hari Minggu libur (tidak ada layanan)
 * - Jika hari yang dicoba sudah penuh (>=5 pendaftar), maju ke hari berikutnya
 * Mengembalikan array [hari, tanggal, jam]
 */
function cari_jadwal($conn) {
    global $JAM_SLOT;
    $kapasitas = count($JAM_SLOT);

    // mulai dicoba dari besok
    $tgl_coba = new DateTime("tomorrow");

    while (true) {
        // lewati hari Minggu (libur)
        if ($tgl_coba->format("l") === "Sunday") {
            $tgl_coba->modify("+1 day");
            continue;
        }

        $tglStr = $tgl_coba->format("Y-m-d");

        // hitung berapa orang yang sudah terjadwal di tanggal ini
        $stmt = $conn->prepare("SELECT COUNT(*) AS jml FROM pendaftaran WHERE tanggal = ?");
        $stmt->bind_param("s", $tglStr);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $jumlah = (int) $res["jml"];

        if ($jumlah < $kapasitas) {
            // masih ada slot tersedia di hari ini
            $jam = $JAM_SLOT[$jumlah]; // slot ke-(jumlah) yang tersedia
            $hari = hari_indonesia($tglStr);
            return [$hari, $tglStr, $jam];
        }

        // sudah penuh -> maju ke hari berikutnya
        $tgl_coba->modify("+1 day");
    }
}

/**
 * Generate nomor antrian otomatis, format: ANT-YYYYMMDD-NNN
 * NNN adalah urutan pada tanggal kedatangan tersebut
 */
function generate_no_antrian($conn, $tgl_datang) {
    $kode_tgl = date("Ymd", strtotime($tgl_datang));

    $stmt = $conn->prepare("SELECT COUNT(*) AS jml FROM daftar_ulang WHERE tgl_datang = ? AND keterangan = 'OK'");
    $stmt->bind_param("s", $tgl_datang);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $urutan = ((int) $res["jml"]) + 1;

    return "ANT-" . $kode_tgl . "-" . str_pad($urutan, 3, "0", STR_PAD_LEFT);
}

/**
 * Menentukan Keterangan pada Daftar Ulang:
 * OK jika KTP, KK, Ijazah/Akte semua "Ada" DAN hari & tanggal datang
 * sesuai (sama) dengan hari & tanggal yang seharusnya (hasil dari fitur Daftar).
 */
function cek_keterangan($ktp, $kk, $ijazah, $hari_datang, $tgl_datang, $hari_harus, $tgl_harus) {
    $berkas_lengkap = ($ktp === "Ada" && $kk === "Ada" && $ijazah === "Ada");
    $hari_sesuai    = ($hari_datang === $hari_harus && $tgl_datang === $tgl_harus);

    return ($berkas_lengkap && $hari_sesuai) ? "OK" : "Tidak";
}

/**
 * Membuat / memperbarui data di tabel pengurusan berdasarkan
 * data daftar_ulang yang keterangannya sudah OK.
 * - Berkas lengkap (KTP, KK, Ijazah/Akte semua Ada) -> Lengkap, Diterima, OK, Bayar 355.000
 * - Selain itu -> Tidak Lengkap, Ditolak, Tidak Lengkap, Bayar 0
 */
function proses_pengurusan($conn, $no_antrian, $no_daftar, $nama_pemohon, $ktp, $kk, $ijazah) {
    $lengkap = ($ktp === "Ada" && $kk === "Ada" && $ijazah === "Ada");

    if ($lengkap) {
        $berkas     = "Lengkap";
        $status     = "Diterima";
        $keterangan = "OK";
        $bayar      = 355000;
    } else {
        $berkas     = "Tidak Lengkap";
        $status     = "Ditolak";
        $keterangan = "Berkas Tidak Lengkap";
        $bayar      = 0;
    }

    $stmt = $conn->prepare("
        INSERT INTO pengurusan (no_antrian, no_daftar, nama_pemohon, berkas, status, keterangan, pembayaran)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            berkas = VALUES(berkas),
            status = VALUES(status),
            keterangan = VALUES(keterangan),
            pembayaran = VALUES(pembayaran)
    ");
    $stmt->bind_param("sissssi", $no_antrian, $no_daftar, $nama_pemohon, $berkas, $status, $keterangan, $bayar);
    $stmt->execute();
}
?>
