# Program Pengajuan Paspor - Kantor Imigrasi Cabang
Dibuat dengan **PHP + MySQL** sesuai soal UAS (fitur: Daftar, Daftar Ulang, Pengurusan).

## 1. Cara Menjalankan (XAMPP / Laragon)

1. Copy folder `paspor_app` ke folder `htdocs` (XAMPP) atau `www` (Laragon).
2. Buka phpMyAdmin, buat database baru lalu import file `database.sql`
   (atau jalankan isi file itu di tab SQL). Ini akan otomatis membuat
   database `db_paspor` beserta 3 tabelnya.
3. Cek pengaturan koneksi di `includes/config.php` (default: host=localhost,
   user=root, password=kosong — sudah cocok untuk XAMPP/Laragon default).
4. Jalankan Apache & MySQL, lalu buka di browser:
   `http://localhost/paspor_app/`

## 2. Alur & Logika Program

### a. Fitur Daftar (`daftar.php`)
- User input **Nama Pemohon** lalu klik **Simpan**.
- Sistem OTOMATIS menghitung **Hari, Tanggal, Jam** yang harus datang:
  - Kapasitas layanan = **5 orang per hari** (5 slot jam: 08:00, 09:00, 10:00, 11:00, 13:00).
  - Hari Minggu libur (dilewati).
  - Jika hari yang dicoba sudah terisi 5 orang, sistem otomatis maju ke hari berikutnya.
- Data masuk ke tabel `pendaftaran` dan tampil di **Data Pendaftar** (dengan Edit/Hapus).

### b. Fitur Daftar Ulang (`daftar_ulang.php`)
- Pilih **No. Daftar** dari dropdown (nama pemohon & jadwal seharusnya otomatis tampil).
- User isi **Hari Datang / Tgl Datang** (kedatangan aktual) dan centang berkas
  yang dibawa: **KTP, KK, Ijazah/Akte**.
- Sistem menghitung **Keterangan**:
  - **OK** jika KTP+KK+Ijazah/Akte semuanya dicentang **DAN** Hari & Tanggal
    Datang **sesuai** dengan jadwal seharusnya (dari fitur Daftar).
  - **Tidak**, jika salah satu syarat di atas tidak terpenuhi.
- Jika Keterangan = **OK**, sistem otomatis membuat **No. Antrian** (format
  `ANT-YYYYMMDD-NNN`) dan langsung membuat/memperbarui baris di tabel Pengurusan.

### c. Fitur Pengurusan (`pengurusan.php`)
- Data di halaman ini terisi **otomatis** dari hasil Daftar Ulang yang sudah
  mendapat No. Antrian (Keterangan = OK).
- Logika:
  - Jika KTP, KK, Ijazah/Akte semua "Ada" → **Berkas = Lengkap**, **Status = Diterima**,
    **Keterangan = OK**, **Pembayaran = Rp 355.000**.
  - Jika tidak lengkap → **Berkas = Tidak Lengkap**, **Status = Ditolak**,
    **Pembayaran = Rp 0**.
- Di bagian bawah tabel ditampilkan **Total Pendapatan** (jumlah semua
  pembayaran dari status Diterima).

## 3. Struktur File
```
paspor_app/
├── database.sql              -> skema database
├── style.css                 -> tampilan halaman
├── index.php                 -> redirect ke daftar.php
├── daftar.php                -> form + tabel Data Pendaftar
├── daftar_proses.php         -> simpan pendaftaran + hitung jadwal otomatis
├── daftar_edit.php           -> edit data pendaftar
├── daftar_hapus.php          -> hapus data pendaftar
├── daftar_ulang.php          -> form + tabel Data Pendaftar Ulang
├── daftar_ulang_proses.php   -> simpan daftar ulang + hitung keterangan & no antrian
├── daftar_ulang_hapus.php    -> hapus data daftar ulang
├── pengurusan.php            -> tabel Data Pengurusan Paspor + total pendapatan
└── includes/
    ├── config.php            -> koneksi database
    ├── functions.php         -> fungsi logika bisnis (jadwal, no antrian, dll)
    ├── header.php            -> navigasi atas (bisa dipakai ulang di semua halaman)
    └── footer.php
```

## 4. Catatan / Asumsi yang Bisa Disesuaikan
- Jam layanan (5 slot) dan aturan libur hari Minggu adalah asumsi tambahan
  untuk melengkapi soal — silakan ubah di `includes/functions.php`
  (variabel `$JAM_SLOT` dan pengecekan `Sunday`) sesuai ketentuan dosen jika berbeda.
- Format No. Antrian (`ANT-YYYYMMDD-NNN`) bisa diganti sesuai selera di
  fungsi `generate_no_antrian()`.
- Nominal pembayaran Rp 355.000 mengikuti soal; jika ada ketentuan
  tambahan untuk kasus "ditolak" yang berbeda, tinggal ubah di fungsi
  `proses_pengurusan()`.
