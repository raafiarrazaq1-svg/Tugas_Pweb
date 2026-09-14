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
                 produk.tanggal_pembelian,
                 produk.masa_garansi,
                 kategori.nama AS kategori_nama,
                 pelanggan.nama AS pelanggan_nama,
                 pelanggan.no_telepon,
                 pelanggan.email,
                 pelanggan.alamat
          FROM garansi
          INNER JOIN produk ON garansi.produk_id = produk.id
          INNER JOIN kategori ON produk.kategori_id = kategori.id
          INNER JOIN pelanggan ON garansi.pelanggan_id = pelanggan.id
          WHERE garansi.id = $id";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: garansi.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Garansi - Warranty Management</title>

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
                Detail Garansi
            </h1>

            <p>
                Informasi lengkap pengajuan garansi.
            </p>

        </div>

        <div class="detail-card" style="padding: 28px;">

            <div class="section-header">

                <div>

                    <h2>
                        Pengajuan #<?= $data['id']; ?>
                    </h2>

                    <p>
                        Detail informasi garansi.
                    </p>

                </div>

                <span class="status status-<?= strtolower($data['status']); ?>">
                    <?= htmlspecialchars($data['status']); ?>
                </span>

            </div>

            <div class="detail-grid">

                <div class="detail-item">

                    <span>
                        Nama Pelanggan
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['pelanggan_nama']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        No. Telepon
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['no_telepon']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Email
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['email'] ?: '-'); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Alamat
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['alamat'] ?: '-'); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Produk
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['produk_nama']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Merek
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['produk_merek']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Kategori
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['kategori_nama']); ?>
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
                        Tanggal Pembelian
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['tanggal_pembelian']); ?>
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Masa Garansi
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['masa_garansi']); ?> bulan
                    </strong>

                </div>

                <div class="detail-item">

                    <span>
                        Tanggal Pengajuan
                    </span>

                    <strong>
                        <?= htmlspecialchars($data['tanggal_pengajuan']); ?>
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

            <div style="margin-top: 15px;">

                <div class="detail-item">

                    <span>
                        Keterangan
                    </span>

                    <strong>
                        <?= $data['keterangan']
                            ? nl2br(htmlspecialchars($data['keterangan']))
                            : '-'; ?>
                    </strong>

                </div>

            </div>

            <div class="form-actions">

                <?php if ($data['status'] == 'Diajukan'): ?>

                    <a
                        href="garansi_proses.php?id=<?= $data['id']; ?>"
                        class="btn-primary"
                    >
                        Proses Pengajuan
                    </a>

                <?php elseif ($data['status'] == 'Diproses'): ?>

                    <a
                        href="garansi_selesai.php?id=<?= $data['id']; ?>"
                        class="btn-primary"
                    >
                        Selesaikan Garansi
                    </a>

                <?php endif; ?>

                <a
                    href="garansi.php"
                    class="btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </div>

    </main>

</div>

</body>
</html>