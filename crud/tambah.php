<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Tambah Data Mahasiswa</h2>
    <form action="" method="post">
        <table>
            <tr>
                <td width="150">Nama</td>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim" required></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td><input type="text" name="jurusan" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="simpan" value="Simpan"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="index.php" class="btn-kembali">Kembali</a>

    <?php
    include 'koneksi.php';
    if (isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $jurusan = $_POST['jurusan'];

        mysqli_query($koneksi, "INSERT INTO mahasiswa VALUES('', '$nama', '$nim', '$jurusan')");
        
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
    }
    ?>
</body>
</html>