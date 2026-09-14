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

if (!isset($_GET['id'])) {
    header("Location: garansi.php");
    exit;
}

$id = (int) $_GET['id'];

$query = "SELECT garansi.*,
                 produk.nama AS produk_nama,
                 produk.merek AS produk_merek,
                 produk.nomor_seri,
                 pelanggan.nama AS pelanggan_nama
          FROM garansi
          INNER JOIN produk ON garansi.produk_id = produk.id
          INNER JOIN pelanggan ON garansi.pelanggan_id = pelanggan.id
          WHERE garansi.id = $id";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: garansi.php");
    exit;
}

if ($data['status'] != 'Diproses') {
    header("Location: garansi_detail.php?id=$id");
    exit;
}

$error = "";

if (isset($_POST['selesai'])) {

    $keterangan = mysqli_real_escape_string(
        $conn,
        $_POST['keterangan']
    );

    if ($keterangan == "") {

        $error = "Keterangan penyelesaian harus diisi.";

    } else {

        $query_update = "UPDATE garansi SET
                         status = 'Selesai',
                         keterangan = '$keterangan'
                         WHERE id = $id";

        if (mysqli_query($conn, $query_update)) {

            header("Location: garansi_detail.php?id=$id");
            exit;

        } else {

            $error = "Pengajuan gagal diselesaikan.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Selesaikan Garansi - Warranty Management</title>

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
                Selesaikan Garansi
            </h1>

            <p>
                Selesaikan proses pengajuan garansi.
            </p>

        </div>

        <?php if ($error != ""): ?>

            <div class="alert error">
                <?= htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <div class="form-card">

            <div class="detail-grid">

                <div class="detail-item">

                    <span>
                        Pelanggan
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['pelanggan_nama']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Produk
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['produk_merek']); ?>
                        <?= htmlspecialchars($data['produk_nama']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Nomor Seri
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['nomor_seri']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Status Saat Ini
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['status']); ?>
                    </strong>

                </div>

            </div>

            <div style="margin-top: 20px;">

                <div class="detail-item">

                    <span>
                        Keluhan
                    </span>

                    <strong>
                        <?= nl2br(htmlspecialchars($data['keluhan'])); ?>
                    </strong>

                </div>

            </div>

            <form method="POST">

                <div class="form-group" style="margin-top: 20px;">

                    <label>
                        Keterangan Penyelesaian
                    </label>

                    <textarea
                        name="keterangan"
                        placeholder="Masukkan hasil atau keterangan penyelesaian garansi"
                        required
                    ></textarea>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="selesai"
                        class="btn-primary"
                        onclick="return confirm('Yakin ingin menyelesaikan garansi ini?')"
                    >
                        Selesaikan Garansi
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