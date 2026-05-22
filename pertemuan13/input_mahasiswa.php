<!DOCTYPE html>
<html>
<head>
    <title>Form Input Data Mahasiswa</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background-color:#f4f4f4;
        }

        .container{
            width:600px;
            margin:50px auto;
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        h3{
            text-align:center;
            color:orange;
            margin-bottom:30px;
        }

        table{
            width:100%;
        }

        td{
            padding:10px;
        }

        input, select{
            width:100%;
            padding:8px;
        }

        .btn{
            width:80px;
            padding:6px;
            margin-right:10px;
        }

        .center{
            text-align:center;
        }
    </style>

</head>
<body>

<div class="container">

<h3>Form Input Data Mahasiswa</h3>

<form action="proses.php" method="POST">

<table>

<tr>
    <td>ID Mahasiswa / NIM</td>
    <td>
        <input type="text" name="id_mahasiswa">
    </td>
</tr>

<tr>
    <td>Nama</td>
    <td>
        <input type="text" name="nama">
    </td>
</tr>

<tr>
    <td>Jurusan</td>
    <td>
        <select name="jurusan">
            <option>Pilih Jurusan</option>
            <option>Informatika</option>
            <option>Sistem Informasi</option>
            <option>Teknik Komputer</option>
            <option>Manajemen</option>
        </select>
    </td>
</tr>

<tr>
    <td>Alamat</td>
    <td>
        <input type="text" name="alamat">
    </td>
</tr>

<tr>
    <td>No. Telp</td>
    <td>
        <input type="text" name="telepon">
    </td>
</tr>

<tr>
    <td colspan="2" class="center">
        <input type="submit" value="Submit" class="btn">
        <input type="reset" value="Cancel" class="btn">
    </td>
</tr>

</table>

</form>

</div>

</body>
</html>