<?php 
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id='$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Data Mahasiswa</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <table>
            <tr>
                <td width="150">Nama</td>
                <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" required></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim" value="<?php echo $data['nim']; ?>" required></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td><input type="text" name="jurusan" value="<?php echo $data['jurusan']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="index.php" class="btn-kembali">Kembali</a>

    <?php
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $jurusan = $_POST['jurusan'];

        mysqli_query($koneksi, "UPDATE mahasiswa SET nama='$nama', nim='$nim', jurusan='$jurusan' WHERE id='$id'");
        
        echo "<script>alert('Data berhasil diubah!'); window.location='index.php';</script>";
    }
    ?>
</body>
</html>