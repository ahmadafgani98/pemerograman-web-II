<!DOCTYPE html>
<html>
<head>
    <title>P10 - Latihan 1: Create Database & Table</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 30px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #1e3c72;
            border-bottom: 3px solid #2a5298;
            padding-bottom: 15px;
        }
        h2 {
            color: #2a5298;
            margin-top: 25px;
        }
        .sql-box {
            background: #1a202c;
            color: #68d391;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            margin: 20px 0;
            overflow-x: auto;
        }
        .success {
            background: #c6f6d5;
            color: #276749;
            padding: 15px;
            border-radius: 10px;
            border-left: 5px solid #38a169;
            margin: 15px 0;
        }
        .error {
            background: #fed7d7;
            color: #c53030;
            padding: 15px;
            border-radius: 10px;
            border-left: 5px solid #e53e3e;
            margin: 15px 0;
        }
        .info {
            background: #ebf8ff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #1e3c72;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        code {
            background: #2d3748;
            color: #fbd38d;
            padding: 3px 8px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Pertemuan 10 - Operasi Database</h1>
        <h2>Latihan 1: Membuat Database dan Tabel</h2>
        
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_perpustakaan";
        
        // Koneksi ke MySQL
        $conn = @mysqli_connect($servername, $username, $password);
        
        if (!$conn) {
            echo "<div class='error'>❌ Koneksi gagal: " . mysqli_connect_error() . "</div>";
        } else {
            echo "<div class='success'>✅ Koneksi ke MySQL berhasil!</div>";
            
            // 1. CREATE DATABASE
            echo "<div class='sql-box'>";
            echo "-- Query Membuat Database --<br>";
            echo "CREATE DATABASE IF NOT EXISTS $dbname;";
            echo "</div>";
            
            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='success'>✅ Database <strong>'$dbname'</strong> berhasil dibuat!</div>";
            } else {
                echo "<div class='error'>❌ Error: " . mysqli_error($conn) . "</div>";
            }
            
            // Pilih database
            mysqli_select_db($conn, $dbname);
            
            // 2. CREATE TABLE - Buku
            echo "<div class='sql-box'>";
            echo "-- Query Membuat Tabel Buku --<br>";
            echo "CREATE TABLE buku (<br>";
            echo "&nbsp;&nbsp;id_buku INT NOT NULL AUTO_INCREMENT,<br>";
            echo "&nbsp;&nbsp;PRIMARY KEY(id_buku),<br>";
            echo "&nbsp;&nbsp;judul VARCHAR(100) NOT NULL,<br>";
            echo "&nbsp;&nbsp;pengarang VARCHAR(50),<br>";
            echo "&nbsp;&nbsp;penerbit VARCHAR(50),<br>";
            echo "&nbsp;&nbsp;tahun_terbit INT,<br>";
            echo "&nbsp;&nbsp;stok INT DEFAULT 1<br>";
            echo ");";
            echo "</div>";
            
            $sql_buku = "CREATE TABLE IF NOT EXISTS buku (
                id_buku INT NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id_buku),
                judul VARCHAR(100) NOT NULL,
                pengarang VARCHAR(50),
                penerbit VARCHAR(50),
                tahun_terbit INT,
                stok INT DEFAULT 1
            )";
            
            if (mysqli_query($conn, $sql_buku)) {
                echo "<div class='success'>✅ Tabel <strong>'buku'</strong> berhasil dibuat!</div>";
            } else {
                echo "<div class='error'>❌ Error: " . mysqli_error($conn) . "</div>";
            }
            
            // 3. CREATE TABLE - Anggota
            echo "<div class='sql-box'>";
            echo "-- Query Membuat Tabel Anggota --<br>";
            echo "CREATE TABLE anggota (<br>";
            echo "&nbsp;&nbsp;id_anggota INT NOT NULL AUTO_INCREMENT,<br>";
            echo "&nbsp;&nbsp;PRIMARY KEY(id_anggota),<br>";
            echo "&nbsp;&nbsp;nama VARCHAR(50) NOT NULL,<br>";
            echo "&nbsp;&nbsp;alamat TEXT,<br>";
            echo "&nbsp;&nbsp;telepon VARCHAR(15),<br>";
            echo "&nbsp;&nbsp;email VARCHAR(50)<br>";
            echo ");";
            echo "</div>";
            
            $sql_anggota = "CREATE TABLE IF NOT EXISTS anggota (
                id_anggota INT NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id_anggota),
                nama VARCHAR(50) NOT NULL,
                alamat TEXT,
                telepon VARCHAR(15),
                email VARCHAR(50)
            )";
            
            if (mysqli_query($conn, $sql_anggota)) {
                echo "<div class='success'>✅ Tabel <strong>'anggota'</strong> berhasil dibuat!</div>";
            } else {
                echo "<div class='error'>❌ Error: " . mysqli_error($conn) . "</div>";
            }
            
            // 4. CREATE TABLE - Peminjaman
            echo "<div class='sql-box'>";
            echo "-- Query Membuat Tabel Peminjaman --<br>";
            echo "CREATE TABLE peminjaman (<br>";
            echo "&nbsp;&nbsp;id_pinjam INT NOT NULL AUTO_INCREMENT,<br>";
            echo "&nbsp;&nbsp;PRIMARY KEY(id_pinjam),<br>";
            echo "&nbsp;&nbsp;id_buku INT,<br>";
            echo "&nbsp;&nbsp;id_anggota INT,<br>";
            echo "&nbsp;&nbsp;tgl_pinjam DATE,<br>";
            echo "&nbsp;&nbsp;tgl_kembali DATE,<br>";
            echo "&nbsp;&nbsp;status ENUM('dipinjam', 'kembali') DEFAULT 'dipinjam'<br>";
            echo ");";
            echo "</div>";
            
            $sql_peminjaman = "CREATE TABLE IF NOT EXISTS peminjaman (
                id_pinjam INT NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(id_pinjam),
                id_buku INT,
                id_anggota INT,
                tgl_pinjam DATE,
                tgl_kembali DATE,
                status ENUM('dipinjam', 'kembali') DEFAULT 'dipinjam'
            )";
            
            if (mysqli_query($conn, $sql_peminjaman)) {
                echo "<div class='success'>✅ Tabel <strong>'peminjaman'</strong> berhasil dibuat!</div>";
            } else {
                echo "<div class='error'>❌ Error: " . mysqli_error($conn) . "</div>";
            }
            
            // Tampilkan daftar tabel
            echo "<h3>📊 Daftar Tabel dalam Database '$dbname':</h3>";
            $result = mysqli_query($conn, "SHOW TABLES");
            
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>No</th><th>Nama Tabel</th></tr>";
                $no = 1;
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>$no</td><td>{$row[0]}</td></tr>";
                    $no++;
                }
                echo "</table>";
            }
            
            mysqli_close($conn);
        }
        ?>
        
        <div class="info">
            <h3>📝 Jenis-jenis Query SQL:</h3>
            <table>
                <tr><th>Kategori</th><th>Perintah</th><th>Fungsi</th></tr>
                <tr><td rowspan="3">DDL (Data Definition Language)</td>
                    <td><code>CREATE DATABASE</code></td><td>Membuat database baru</td></tr>
                <tr><td><code>CREATE TABLE</code></td><td>Membuat tabel baru</td></tr>
                <tr><td><code>DROP DATABASE/TABLE</code></td><td>Menghapus database/tabel</td></tr>
                <tr><td rowspan="4">DML (Data Manipulation Language)</td>
                    <td><code>INSERT</code></td><td>Menambah data</td></tr>
                <tr><td><code>SELECT</code></td><td>Mengambil/menampilkan data</td></tr>
                <tr><td><code>UPDATE</code></td><td>Mengubah data</td></tr>
                <tr><td><code>DELETE</code></td><td>Menghapus data</td></tr>
            </table>
        </div>
    </div>
</body>
</html>