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

$query = "SELECT garansi.*,
                 produk.nama AS produk_nama,
                 produk.merek AS produk_merek,
                 produk.nomor_seri,
                 pelanggan.nama AS pelanggan_nama
          FROM garansi
          INNER JOIN produk ON garansi.produk_id = produk.id
          INNER JOIN pelanggan ON garansi.pelanggan_id = pelanggan.id
          ORDER BY garansi.id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Garansi - Warranty Management</title>

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

        <div class="sidebar-bottom">

            <div class="admin-info">

                <strong>
                    <?= htmlspecialchars($_SESSION['admin_nama']); ?>
                </strong>

                <span>
                    Administrator
                </span>

            </div>

            <a href="logout.php" class="logout">
                Logout
            </a>

        </div>

    </aside>

    <main class="content">

        <div class="topbar">

            <p class="eyebrow">
                WARRANTY SERVICE
            </p>

            <h1>
                Garansi
            </h1>

            <p>
                Kelola pengajuan garansi pelanggan.
            </p>

        </div>

        <div class="table-card">

            <div class="section-header">

                <div>

                    <h2>
                        Data Pengajuan Garansi
                    </h2>

                    <p>
                        Daftar pengajuan garansi yang masuk.
                    </p>

                </div>

                <a href="garansi_tambah.php" class="btn-primary">
                    + Ajukan Garansi
                </a>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Nomor Seri</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    if (mysqli_num_rows($result) > 0):

                        while ($row = mysqli_fetch_assoc($result)):

                    ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['pelanggan_nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['produk_merek']); ?>
                                <?= htmlspecialchars($row['produk_nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nomor_seri']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['tanggal_pengajuan']); ?>
                            </td>

                            <td>

                                <span class="status status-<?= strtolower($row['status']); ?>">
                                    <?= htmlspecialchars($row['status']); ?>
                                </span>

                            </td>

                            <td>

                                <a
                                    href="garansi_detail.php?id=<?= $row['id']; ?>"
                                    class="action-link"
                                >
                                    Detail
                                </a>

                                <?php if ($row['status'] == 'Diajukan'): ?>

                                    <a
                                        href="garansi_proses.php?id=<?= $row['id']; ?>"
                                        class="action-link"
                                    >
                                        Proses
                                    </a>

                                <?php elseif ($row['status'] == 'Diproses'): ?>

                                    <a
                                        href="garansi_selesai.php?id=<?= $row['id']; ?>"
                                        class="action-link"
                                    >
                                        Selesaikan
                                    </a>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php

                        endwhile;

                    else:

                    ?>

                        <tr>

                            <td
                                colspan="7"
                                style="text-align: center; color: #8993a5;"
                            >
                                Belum ada pengajuan garansi.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>