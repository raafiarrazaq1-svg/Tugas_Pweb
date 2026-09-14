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
        "SELECT id FROM produk WHERE nomor_seri = '$nomor_seri'"
    );

    if (mysqli_num_rows($cek) > 0) {

        $error = "Nomor seri tersebut sudah digunakan.";

    } else {

        $query = "INSERT INTO produk
                  (kategori_id, nama, merek, nomor_seri, tanggal_pembelian, masa_garansi)
                  VALUES
                  ($kategori_id, '$nama', '$merek', '$nomor_seri', '$tanggal_pembelian', $masa_garansi)";

        if (mysqli_query($conn, $query)) {

            header("Location: produk.php");
            exit;

        } else {

            $error = "Data produk gagal disimpan.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - Warranty Management</title>

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
                Tambah Produk
            </h1>

            <p>
                Masukkan data produk baru.
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

                            <option value="<?= $kategori['id']; ?>">

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
                        placeholder="Contoh: Galaxy S25"
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
                        placeholder="Contoh: Samsung"
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
                        placeholder="Masukkan nomor seri produk"
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
                        placeholder="Contoh: 12"
                        required
                    >

                    <small style="display: block; margin-top: 7px; color: #8993a5;">
                        Masukkan masa garansi dalam bulan.
                    </small>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-primary"
                    >
                        Simpan Produk
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