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

$produk_query = "SELECT produk.*, kategori.nama AS kategori_nama
                 FROM produk
                 INNER JOIN kategori ON produk.kategori_id = kategori.id
                 ORDER BY produk.nama ASC";

$produk_result = mysqli_query($conn, $produk_query);

$pelanggan_query = "SELECT * FROM pelanggan ORDER BY nama ASC";

$pelanggan_result = mysqli_query($conn, $pelanggan_query);

$error = "";

if (isset($_POST['simpan'])) {

    $produk_id = (int) $_POST['produk_id'];
    $pelanggan_id = (int) $_POST['pelanggan_id'];
    $tanggal_pengajuan = mysqli_real_escape_string(
        $conn,
        $_POST['tanggal_pengajuan']
    );
    $keluhan = mysqli_real_escape_string(
        $conn,
        $_POST['keluhan']
    );

    $query = "INSERT INTO garansi
              (produk_id, pelanggan_id, tanggal_pengajuan, keluhan, status)
              VALUES
              ($produk_id, $pelanggan_id, '$tanggal_pengajuan', '$keluhan', 'Diajukan')";

    if (mysqli_query($conn, $query)) {

        header("Location: garansi.php");
        exit;

    } else {

        $error = "Pengajuan garansi gagal disimpan.";

    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajukan Garansi - Warranty Management</title>

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

            <a href="pelanggan.php">
                Pelanggan
            </a>

            <a href="garansi.php" class="active">
                Garansi
            </a>

        </nav>

    </aside>

    <main class="content">

        <div class="topbar">

            <p class="eyebrow">
                WARRANTY SERVICE
            </p>

            <h1>
                Ajukan Garansi
            </h1>

            <p>
                Masukkan data pengajuan garansi pelanggan.
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
                        Pelanggan
                    </label>

                    <select name="pelanggan_id" required>

                        <option value="">
                            -- Pilih Pelanggan --
                        </option>

                        <?php while ($pelanggan = mysqli_fetch_assoc($pelanggan_result)): ?>

                            <option value="<?= $pelanggan['id']; ?>">

                                <?= htmlspecialchars($pelanggan['nama']); ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Produk
                    </label>

                    <select name="produk_id" required>

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        <?php while ($produk = mysqli_fetch_assoc($produk_result)): ?>

                            <option value="<?= $produk['id']; ?>">

                                <?= htmlspecialchars($produk['merek']); ?>
                                -
                                <?= htmlspecialchars($produk['nama']); ?>
                                -
                                <?= htmlspecialchars($produk['nomor_seri']); ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Tanggal Pengajuan
                    </label>

                    <input
                        type="date"
                        name="tanggal_pengajuan"
                        value="<?= date('Y-m-d'); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Keluhan
                    </label>

                    <textarea
                        name="keluhan"
                        placeholder="Masukkan keluhan pelanggan"
                        required
                    ></textarea>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-primary"
                    >
                        Ajukan Garansi
                    </button>

                    <a
                        href="garansi.php"
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