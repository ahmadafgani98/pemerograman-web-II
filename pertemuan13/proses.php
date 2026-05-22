<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "kampus_db"
);

$id = $_POST['id_mahasiswa'];
$nama = $_POST['nama'];
$jurusan = $_POST['jurusan'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

mysqli_query($conn,
"INSERT INTO mahasiswa VALUES
('$id','$nama','$jurusan','$alamat','$telepon')");

echo "Data berhasil disimpan";

?>