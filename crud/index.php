<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
       <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Mahasiswa</h2>
    <a href="tambah.php" class="btn-tambah">+ Tambah Data</a>
    
    <table class="data-table">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
        while ($row = mysqli_fetch_array($data)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['nim']; ?></td>
            <td><?php echo $row['jurusan']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>