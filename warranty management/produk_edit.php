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
    header("Location: produk.php");
    exit;
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM produk WHERE id = $id";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: produk.php");
    exit;
}

$kategori_query = "SELECT * FROM kategori ORDER BY nama ASC";

$kategori_result = mysqli_query($conn, $kategori_query);

$error = "";

if (isset($_POST['simpan'])) {

    $kategori_id = (int) $_POST['kategori_id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $merek = mysqli_real_escape_string($conn, $_POST['merek']);
    $nomor_seri = mysqli_real_escape_string($conn, $_POST['nomor_seri']);
    $tanggal_pembelian = mysqli_real_escape_string($conn, $_POST['tanggal_pembelian']);
    $masa_garansi = (int) $_POST['masa_garansi'];

    $cek = mysqli_query(
        $conn,
        "SELECT id FROM produk
         WHERE nomor_seri = '$nomor_seri'
         AND id != $id"
    );

    if (mysqli_num_rows($cek) > 0) {

        $error = "Nomor seri tersebut sudah digunakan oleh produk lain.";

    } else {

        $update = "UPDATE produk SET
                   kategori_id = $kategori_id,
                   nama = '$nama',
                   merek = '$merek',
                   nomor_seri = '$nomor_seri',
                   tanggal_pembelian = '$tanggal_pembelian',
                   masa_garansi = $masa_garansi
                   WHERE id = $id";

        if (mysqli_query($conn, $update)) {

            header("Location: produk.php");
            exit;

        } else {

            $error = "Data produk gagal diperbarui.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk - Warranty Management</title>

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

                <strong>
                    Warranty
                </strong>

                <span>
                    Management
                </span>

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

    </aside>

    <main class="content">

        <div class="topbar">

            <p class="eyebrow">
                MASTER DATA
            </p>

            <h1>
                Edit Produk
            </h1>

            <p>
                Ubah informasi produk.
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
                        Kategori
                    </label>

                    <select name="kategori_id" required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <?php while ($kategori = mysqli_fetch_assoc($kategori_result)): ?>

                            <option
                                value="<?= $kategori['id']; ?>"
                                <?= $data['kategori_id'] == $kategori['id'] ? 'selected' : ''; ?>
                            >

                                <?= htmlspecialchars($kategori['nama']); ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label>
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="<?= htmlspecialchars($data['nama']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Merek
                    </label>

                    <input
                        type="text"
                        name="merek"
                        value="<?= htmlspecialchars($data['merek']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Nomor Seri
                    </label>

                    <input
                        type="text"
                        name="nomor_seri"
                        value="<?= htmlspecialchars($data['nomor_seri']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Tanggal Pembelian
                    </label>

                    <input
                        type="date"
                        name="tanggal_pembelian"
                        value="<?= htmlspecialchars($data['tanggal_pembelian']); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Masa Garansi
                    </label>

                    <input
                        type="number"
                        name="masa_garansi"
                        min="1"
                        value="<?= htmlspecialchars($data['masa_garansi']); ?>"
                        required
                    >

                    <small style="display: block; margin-top: 7px; color: #8993a5;">
                        Masa garansi dalam bulan.
                    </small>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-primary"
                    >
                        Simpan Perubahan
                    </button>

                    <a
                        href="produk.php"
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