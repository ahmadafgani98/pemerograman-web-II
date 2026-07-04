-- =========================================================
-- DATABASE: db_paspor
-- Program Pengajuan Paspor - Kantor Imigrasi Cabang
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_paspor;
USE db_paspor;

-- ---------------------------------------------------------
-- TABEL 1: PENDAFTARAN (fitur "Daftar")
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS pendaftaran (
    no_daftar     INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemohon  VARCHAR(100) NOT NULL,
    tgl_daftar    DATE NOT NULL,          -- tanggal mendaftar (hari ini)
    hari          VARCHAR(15) NOT NULL,   -- hari HARUS DATANG (dihitung sistem)
    tanggal       DATE NOT NULL,          -- tanggal HARUS DATANG (dihitung sistem)
    jam           VARCHAR(10) NOT NULL,   -- jam HARUS DATANG (dihitung sistem)
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- TABEL 2: DAFTAR ULANG (fitur "Daftar Ulang")
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS daftar_ulang (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    no_daftar           INT NOT NULL,
    nama_pemohon        VARCHAR(100) NOT NULL,
    keperluan           VARCHAR(100) NOT NULL,
    hari_harus_datang   VARCHAR(15) NOT NULL,
    tgl_harus_datang    DATE NOT NULL,
    hari_datang         VARCHAR(15) NOT NULL,   -- diisi user: hari kedatangan aktual
    tgl_datang          DATE NOT NULL,          -- diisi user: tanggal kedatangan aktual
    ktp                 ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    kk                  ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    ijazah_akte         ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    keterangan          ENUM('OK','Tidak') NOT NULL DEFAULT 'Tidak',
    no_antrian          VARCHAR(20) DEFAULT NULL,   -- otomatis, hanya jika keterangan = OK
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (no_daftar) REFERENCES pendaftaran(no_daftar) ON DELETE CASCADE
);

-- ---------------------------------------------------------
-- TABEL 3: PENGURUSAN PASPOR (fitur "Pengurusan")
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS pengurusan (
    no_antrian     VARCHAR(20) PRIMARY KEY,
    no_daftar      INT NOT NULL,
    nama_pemohon   VARCHAR(100) NOT NULL,
    berkas         ENUM('Lengkap','Tidak Lengkap') NOT NULL,
    status         ENUM('Diterima','Ditolak') NOT NULL,
    keterangan     VARCHAR(30) NOT NULL,
    pembayaran     INT NOT NULL DEFAULT 0,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (no_daftar) REFERENCES pendaftaran(no_daftar) ON DELETE CASCADE
);
