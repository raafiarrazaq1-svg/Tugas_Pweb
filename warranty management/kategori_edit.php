<?php

session_start();
require_once "database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = (int) $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM kategori WHERE id = $id"
);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: kategori.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "UPDATE kategori
              SET nama = '$nama',
                  deskripsi = '$deskripsi'
              WHERE id = $id";

    mysqli_query($conn, $query);

    header("Location: kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Warranty Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app">

    <aside class="sidebar">

        <div class="logo">
            <div class="logo-mark">W</div>
            <div>
                <strong>Warranty</strong>
                <span>Management</span>
            </div>
        </div>

        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="kategori.php" class="active">Kategori</a>
            <a href="produk.php">Produk</a>
            <a href="pelanggan.php">Pelanggan</a>
            <a href="garansi.php">Garansi</a>
        </nav>

    </aside>

    <main class="content">

        <div class="topbar">
            <p class="eyebrow">MASTER DATA</p>
            <h1>Edit Kategori</h1>
            <p>Ubah data kategori.</p>
        </div>

        <div class="form-card">

            <form method="POST">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text"
                           name="nama"
                           value="<?= htmlspecialchars($data['nama']); ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                </div>

                <div class="form-actions">

                    <button type="submit" name="simpan" class="btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="kategori.php" class="btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>