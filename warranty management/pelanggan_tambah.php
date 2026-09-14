<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "warranty_management");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "INSERT INTO pelanggan
              (nama, no_telepon, email, alamat)
              VALUES
              ('$nama', '$no_telepon', '$email', '$alamat')";

    if (mysqli_query($conn, $query)) {

        header("Location: pelanggan.php");
        exit;

    } else {

        $error = "Data pelanggan gagal disimpan.";

    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pelanggan - Warranty Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="app">

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-mark">
                W
            </div>

            <div>
                <strong>Warranty</strong>
                <span>Management</span>
            </div>

        </div>

        <nav>

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="kategori.php">
                Kategori
            </a>

            <a href="produk.php">
                Produk
            </a>

            <a href="pelanggan.php" class="active">
                Pelanggan
            </a>

            <a href="garansi.php">
                Garansi
            </a>

        </nav>

    </aside>

    <main class="content">

        <div class="topbar">

            <p class="eyebrow">
                MASTER DATA
            </p>

            <h1>
                Tambah Pelanggan
            </h1>

            <p>
                Masukkan data pelanggan baru.
            </p>

        </div>

        <?php if ($error != ""): ?>

            <div class="alert error">
                <?= htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <div class="form-card">

            <form method="POST">

                <div class="form-group">

                    <label>
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama pelanggan"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        name="no_telepon"
                        placeholder="Masukkan nomor telepon"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Masukkan email"
                    >

                </div>

                <div class="form-group">

                    <label>
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        placeholder="Masukkan alamat pelanggan"
                    ></textarea>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-primary"
                    >
                        Simpan Pelanggan
                    </button>

                    <a
                        href="pelanggan.php"
                        class="btn-secondary"
                    >
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>