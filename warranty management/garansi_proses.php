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

if ($data['status'] != 'Diajukan') {
    header("Location: garansi_detail.php?id=$id");
    exit;
}

$error = "";

if (isset($_POST['proses'])) {

    $keterangan = mysqli_real_escape_string(
        $conn,
        $_POST['keterangan']
    );

    $query_update = "UPDATE garansi SET
                     status = 'Diproses',
                     keterangan = '$keterangan'
                     WHERE id = $id";

    if (mysqli_query($conn, $query_update)) {

        header("Location: garansi_detail.php?id=$id");
        exit;

    } else {

        $error = "Pengajuan gagal diproses.";

    }
}

if (isset($_POST['tolak'])) {

    $keterangan = mysqli_real_escape_string(
        $conn,
        $_POST['keterangan']
    );

    if ($keterangan == "") {
        $error = "Keterangan penolakan harus diisi.";
    } else {

        $query_update = "UPDATE garansi SET
                         status = 'Ditolak',
                         keterangan = '$keterangan'
                         WHERE id = $id";

        if (mysqli_query($conn, $query_update)) {

            header("Location: garansi_detail.php?id=$id");
            exit;

        } else {

            $error = "Pengajuan gagal ditolak.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proses Garansi - Warranty Management</title>

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
                Proses Garansi
            </h1>

            <p>
                Tentukan tindakan untuk pengajuan garansi.
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

            <form method="POST">

                <div class="form-group" style="margin-top: 20px;">

                    <label>
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        placeholder="Masukkan keterangan proses atau alasan penolakan"
                    ></textarea>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="proses"
                        class="btn-primary"
                    >
                        Proses Garansi
                    </button>

                    <button
                        type="submit"
                        name="tolak"
                        class="btn-danger"
                        onclick="return confirm('Yakin ingin menolak pengajuan ini?')"
                    >
                        Tolak Pengajuan
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