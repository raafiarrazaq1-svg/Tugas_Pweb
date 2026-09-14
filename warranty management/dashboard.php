<?php

session_start();
require_once "database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$total_kategori = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM kategori")
)['total'];

$total_produk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk")
)['total'];

$total_pelanggan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelanggan")
)['total'];

$total_garansi = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM garansi")
)['total'];

$garansi_diajukan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM garansi WHERE status = 'Diajukan'")
)['total'];

$garansi_diproses = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM garansi WHERE status = 'Diproses'")
)['total'];

$garansi_selesai = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM garansi WHERE status = 'Selesai'")
)['total'];

$garansi_ditolak = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM garansi WHERE status = 'Ditolak'")
)['total'];

$garansi_terbaru = mysqli_query(
    $conn,
    "SELECT garansi.*, pelanggan.nama AS pelanggan_nama,
            produk.nama AS produk_nama
     FROM garansi
     INNER JOIN pelanggan ON garansi.pelanggan_id = pelanggan.id
     INNER JOIN produk ON garansi.produk_id = produk.id
     ORDER BY garansi.id DESC
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Warranty Management</title>
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

            <a href="dashboard.php" class="active">
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

            <a href="garansi.php">
                Garansi
            </a>

        </nav>

        <div class="sidebar-bottom">
            <div class="admin-info">
                <strong><?= htmlspecialchars($_SESSION['admin_nama']); ?></strong>
                <span>Administrator</span>
            </div>

            <a href="logout.php" class="logout">
                Logout
            </a>
        </div>

    </aside>

    <main class="content">

        <div class="topbar">
            <div>
                <p class="eyebrow">WARRANTY MANAGEMENT</p>
                <h1>Dashboard</h1>
                <p>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama']); ?>.</p>
            </div>
        </div>

        <div class="stats-grid">

            <div class="stat-card">
                <span>Total Kategori</span>
                <strong><?= $total_kategori; ?></strong>
            </div>

            <div class="stat-card">
                <span>Total Produk</span>
                <strong><?= $total_produk; ?></strong>
            </div>

            <div class="stat-card">
                <span>Total Pelanggan</span>
                <strong><?= $total_pelanggan; ?></strong>
            </div>

            <div class="stat-card">
                <span>Total Pengajuan</span>
                <strong><?= $total_garansi; ?></strong>
            </div>

        </div>

        <div class="status-grid">

            <div class="status-card">
                <span>Diajukan</span>
                <strong><?= $garansi_diajukan; ?></strong>
            </div>

            <div class="status-card">
                <span>Diproses</span>
                <strong><?= $garansi_diproses; ?></strong>
            </div>

            <div class="status-card">
                <span>Selesai</span>
                <strong><?= $garansi_selesai; ?></strong>
            </div>

            <div class="status-card">
                <span>Ditolak</span>
                <strong><?= $garansi_ditolak; ?></strong>
            </div>

        </div>

        <div class="table-card">

            <div class="section-header">
                <div>
                    <h2>Pengajuan Garansi Terbaru</h2>
                    <p>Data pengajuan garansi terbaru.</p>
                </div>

                <a href="garansi.php" class="btn-secondary">
                    Lihat Semua
                </a>
            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    while ($row = mysqli_fetch_assoc($garansi_terbaru)):
                    ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td>
                                <?= htmlspecialchars($row['pelanggan_nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['produk_nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['tanggal_pengajuan']); ?>
                            </td>

                            <td>
                                <span class="status status-<?= strtolower($row['status']); ?>">
                                    <?= htmlspecialchars($row['status']); ?>
                                </span>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>