<!DOCTYPE html>
<html>
<head>
    <title>P10 - Latihan 2: Operasi CRUD</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 30px;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 1100px;
            margin: 0 auto;
        }
        h1 {
            color: #0f2027;
            border-bottom: 3px solid #2c5364;
            padding-bottom: 15px;
        }
        h2 {
            color: #2c5364;
            margin-top: 25px;
            padding: 10px;
            background: #e8f4f8;
            border-radius: 5px;
        }
        .sql-box {
            background: #1a202c;
            color: #68d391;
            padding: 15px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
        }
        .success {
            background: #c6f6d5;
            color: #276749;
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .error {
            background: #fed7d7;
            color: #c53030;
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #2c5364;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .crud-section {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            background: #fafafa;
        }
        code {
            background: #2d3748;
            color: #fbd38d;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Pertemuan 10 - Operasi CRUD</h1>
        
        <?php
        $conn = @mysqli_connect('localhost', 'root', '', 'db_perpustakaan');
        
        if (!$conn) {
            echo "<div class='error'>❌ Database belum dibuat. Jalankan Latihan 1 terlebih dahulu!</div>";
        } else {
            ?>
            
            <!-- INSERT DATA -->
            <div class="crud-section">
                <h2>1️⃣ INSERT - Memasukkan Data</h2>
                
                <div class="sql-box">
                    INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok) VALUES<br>
                    ('Pemrograman Web', 'Budi Santoso', 'Informatika', 2023, 5);
                </div>
                
                <?php
                // Data buku
                $buku_data = [
                    ['Pemrograman Web', 'Budi Santoso', 'Informatika', 2023, 5],
                    ['Basis Data', 'Siti Aminah', 'Andi Offset', 2022, 3],
                    ['Algoritma Pemrograman', 'Rudi Hartono', 'Erlangga', 2021, 4],
                    ['Jaringan Komputer', 'Dewi Lestari', 'Salemba', 2023, 2]
                ];
                
                foreach ($buku_data as $buku) {
                    $sql = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok) 
                            VALUES ('$buku[0]', '$buku[1]', '$buku[2]', $buku[3], $buku[4])";
                    mysqli_query($conn, $sql);
                }
                echo "<div class='success'>✅ Data buku berhasil dimasukkan!</div>";
                
                // Data anggota
                $anggota_data = [
                    ['Andi Wijaya', 'Jl. Merdeka No. 10, Jakarta', '081234567890', 'andi@email.com'],
                    ['Bunga Citra', 'Jl. Mawar No. 5, Bandung', '085678901234', 'bunga@email.com'],
                    ['Cahya Putra', 'Jl. Melati No. 15, Surabaya', '082345678901', 'cahya@email.com']
                ];
                
                foreach ($anggota_data as $anggota) {
                    $sql = "INSERT INTO anggota (nama, alamat, telepon, email) 
                            VALUES ('$anggota[0]', '$anggota[1]', '$anggota[2]', '$anggota[3]')";
                    mysqli_query($conn, $sql);
                }
                echo "<div class='success'>✅ Data anggota berhasil dimasukkan!</div>";
                ?>
            </div>
            
            <!-- SELECT DATA -->
            <div class="crud-section">
                <h2>2️⃣ SELECT - Menampilkan Data</h2>
                
                <div class="sql-box">
                    SELECT * FROM buku;
                </div>
                
                <?php
                $result = mysqli_query($conn, "SELECT * FROM buku");
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Tahun</th><th>Stok</th></tr>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_buku']}</td>";
                        echo "<td>{$row['judul']}</td>";
                        echo "<td>{$row['pengarang']}</td>";
                        echo "<td>{$row['penerbit']}</td>";
                        echo "<td>{$row['tahun_terbit']}</td>";
                        echo "<td>{$row['stok']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
                
                <div class="sql-box" style="margin-top:20px;">
                    SELECT * FROM anggota;
                </div>
                
                <?php
                $result = mysqli_query($conn, "SELECT * FROM anggota");
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Email</th></tr>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_anggota']}</td>";
                        echo "<td>{$row['nama']}</td>";
                        echo "<td>{$row['alamat']}</td>";
                        echo "<td>{$row['telepon']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
            
            <!-- UPDATE DATA -->
            <div class="crud-section">
                <h2>3️⃣ UPDATE - Mengubah Data</h2>
                
                <div class="sql-box">
                    UPDATE buku SET stok = 7 WHERE id_buku = 1;
                </div>
                
                <?php
                mysqli_query($conn, "UPDATE buku SET stok = 7 WHERE id_buku = 1");
                echo "<div class='success'>✅ Stok buku ID 1 diubah menjadi 7!</div>";
                
                // Tampilkan hasil update
                $result = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = 1");
                $row = mysqli_fetch_assoc($result);
                echo "<p>Buku: <strong>{$row['judul']}</strong> - Stok sekarang: <strong>{$row['stok']}</strong></p>";
                ?>
            </div>
            
            <!-- DELETE DATA -->
            <div class="crud-section">
                <h2>4️⃣ DELETE - Menghapus Data</h2>
                
                <div class="sql-box">
                    DELETE FROM buku WHERE id_buku = 4;
                </div>
                
                <?php
                // Cek dulu apakah data ada
                $cek = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = 4");
                if (mysqli_num_rows($cek) > 0) {
                    mysqli_query($conn, "DELETE FROM buku WHERE id_buku = 4");
                    echo "<div class='success'>✅ Data buku ID 4 berhasil dihapus!</div>";
                } else {
                    echo "<div class='error'>⚠️ Data buku ID 4 tidak ditemukan!</div>";
                }
                
                // Tampilkan data setelah delete
                $result = mysqli_query($conn, "SELECT * FROM buku");
                echo "<p><strong>Data setelah DELETE:</strong></p>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Judul</th><th>Stok</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['id_buku']}</td><td>{$row['judul']}</td><td>{$row['stok']}</td></tr>";
                }
                echo "</table>";
                ?>
            </div>
            
            <!-- QUERY DENGAN JOIN -->
            <div class="crud-section">
                <h2>5️⃣ JOIN - Query Multi Tabel</h2>
                
                <div class="sql-box">
                    -- Insert data peminjaman dulu --<br>
                    INSERT INTO peminjaman (id_buku, id_anggota, tgl_pinjam) VALUES<br>
                    (1, 1, '2024-01-15'), (2, 2, '2024-01-16');<br><br>
                    -- Query JOIN --<br>
                    SELECT p.id_pinjam, a.nama, b.judul, p.tgl_pinjam, p.status<br>
                    FROM peminjaman p<br>
                    JOIN anggota a ON p.id_anggota = a.id_anggota<br>
                    JOIN buku b ON p.id_buku = b.id_buku;
                </div>
                
                <?php
                // Insert data peminjaman
                mysqli_query($conn, "INSERT INTO peminjaman (id_buku, id_anggota, tgl_pinjam) VALUES (1, 1, '2024-01-15')");
                mysqli_query($conn, "INSERT INTO peminjaman (id_buku, id_anggota, tgl_pinjam) VALUES (2, 2, '2024-01-16')");
                
                // Query JOIN
                $sql_join = "SELECT p.id_pinjam, a.nama, b.judul, p.tgl_pinjam, p.status 
                             FROM peminjaman p 
                             JOIN anggota a ON p.id_anggota = a.id_anggota 
                             JOIN buku b ON p.id_buku = b.id_buku";
                
                $result = mysqli_query($conn, $sql_join);
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>ID Pinjam</th><th>Nama Anggota</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Status</th></tr>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_pinjam']}</td>";
                        echo "<td>{$row['nama']}</td>";
                        echo "<td>{$row['judul']}</td>";
                        echo "<td>{$row['tgl_pinjam']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
            
            <?php
            mysqli_close($conn);
        }
        ?>
        
        <div style="margin-top:30px; padding:20px; background:#f0f0f0; border-radius:10px;">
            <h3>📌 Ringkasan Query SQL:</h3>
            <table>
                <tr><th>Operasi</th><th>Sintaks</th><th>Contoh</th></tr>
                <tr><td>INSERT</td><td><code>INSERT INTO tabel (kolom) VALUES (nilai)</code></td>
                    <td><code>INSERT INTO buku (judul) VALUES ('PHP')</code></td></tr>
                <tr><td>SELECT</td><td><code>SELECT kolom FROM tabel WHERE kondisi</code></td>
                    <td><code>SELECT * FROM buku WHERE stok > 0</code></td></tr>
                <tr><td>UPDATE</td><td><code>UPDATE tabel SET kolom=nilai WHERE kondisi</code></td>
                    <td><code>UPDATE buku SET stok=5 WHERE id=1</code></td></tr>
                <tr><td>DELETE</td><td><code>DELETE FROM tabel WHERE kondisi</code></td>
                    <td><code>DELETE FROM buku WHERE id=1</code></td></tr>
                <tr><td>JOIN</td><td><code>SELECT * FROM t1 JOIN t2 ON t1.id = t2.id</code></td>
                    <td><code>... JOIN anggota ON p.id_anggota = a.id</code></td></tr>
            </table>
        </div>
    </div>
</body>
</html>