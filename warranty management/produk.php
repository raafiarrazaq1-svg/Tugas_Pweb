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

$query = "SELECT produk.*, kategori.nama AS kategori_nama
          FROM produk
          INNER JOIN kategori ON produk.kategori_id = kategori.id
          ORDER BY produk.id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Warranty Management</title>
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

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="kategori.php">
                Kategori
            </a>

            <a href="produk.php" class="active">
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
                MASTER DATA
            </p>

            <h1>
                Produk
            </h1>

            <p>
                Kelola data produk yang memiliki garansi.
            </p>

        </div>

        <div class="table-card">

            <div class="section-header">

                <div>

                    <h2>
                        Data Produk
                    </h2>

                    <p>
                        Daftar produk yang terdaftar dalam sistem.
                    </p>

                </div>

                <a href="produk_tambah.php" class="btn-primary">
                    + Tambah Produk
                </a>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Nomor Seri</th>
                            <th>Tanggal Pembelian</th>
                            <th>Masa Garansi</th>
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
                                <?= htmlspecialchars($row['nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['merek']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['kategori_nama']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['nomor_seri']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['tanggal_pembelian']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['masa_garansi']); ?> bulan
                            </td>

                            <td>

                                <a
                                    href="produk_edit.php?id=<?= $row['id']; ?>"
                                    class="action-link"
                                >
                                    Edit
                                </a>

                                <a
                                    href="produk_hapus.php?id=<?= $row['id']; ?>"
                                    class="action-link"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                >
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php

                        endwhile;

                    else:

                    ?>

                        <tr>

                            <td colspan="8" style="text-align: center; color: #8993a5;">
                                Belum ada data produk.
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