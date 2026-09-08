<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$query = "SELECT * FROM categories ORDER BY name ASC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Gadget - Gadget Store</title>

    <style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #0f1115;
        color: #e5e7eb;
    }

    /* =====================================================
       APP
       ===================================================== */

    .app {
        display: flex;
        min-height: 100vh;
    }


    /* =====================================================
       SIDEBAR
       ===================================================== */

    .sidebar {
        width: 240px;
        background: #15171c;
        border-right: 1px solid #292d35;
        padding: 25px 18px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #f9fafb;
        margin-bottom: 35px;
    }

    .logo-mark {
        width: 32px;
        height: 32px;
        background: #f9fafb;
        border-radius: 8px;
    }

    .nav-title {
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 25px 10px 10px;
    }

    .nav-link {
        display: block;
        padding: 11px 13px;
        margin-bottom: 4px;
        text-decoration: none;
        color: #9ca3af;
        font-size: 14px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .nav-link:hover {
        background: #20232a;
        color: #f9fafb;
    }

    .nav-link.active {
        background: #f3f4f6;
        color: #111827;
        font-weight: 600;
    }


    /* =====================================================
       MAIN
       ===================================================== */

    .main {
        margin-left: 240px;
        width: calc(100% - 240px);
        min-height: 100vh;
        background: #0f1115;
    }


    /* =====================================================
       TOPBAR
       ===================================================== */

    .topbar {
        height: 82px;
        background: #15171c;
        border-bottom: 1px solid #292d35;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 35px;
    }

    .page-title {
        font-size: 23px;
        font-weight: 700;
        color: #f9fafb;
    }

    .page-subtitle {
        margin-top: 5px;
        font-size: 13px;
        color: #8b93a1;
    }


    /* =====================================================
       USER
       ===================================================== */

    .user-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #f3f4f6;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .user-name {
        font-size: 13px;
        font-weight: 600;
        color: #f3f4f6;
    }

    .user-role {
        margin-top: 3px;
        font-size: 11px;
        color: #7d8491;
    }


    /* =====================================================
       CONTENT
       ===================================================== */

    .content-container {
        padding: 35px;
    }


    /* =====================================================
       CARD
       ===================================================== */

    .data-card {
        background: #15171c;
        border: 1px solid #292d35;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    }

    .data-card-header {
        padding: 22px 25px;
        border-bottom: 1px solid #292d35;
        background: #181a20;
    }

    .data-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #f9fafb;
    }

    .data-card-content {
        padding: 28px;
    }


    /* =====================================================
       FORM
       ===================================================== */

    .data-form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #d1d5db;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        border: 1px solid #363b45;
        background: #101216;
        border-radius: 8px;
        padding: 12px 13px;
        font-size: 13px;
        color: #f3f4f6;
        outline: none;
        transition: 0.2s;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #666d78;
    }

    .form-group input:hover,
    .form-group select:hover,
    .form-group textarea:hover {
        border-color: #4b5563;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #9ca3af;
        background: #14161b;
        box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.08);
    }

    .form-group select {
        cursor: pointer;
    }

    .form-group select option {
        background: #15171c;
        color: #f3f4f6;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 125px;
        line-height: 1.5;
    }

    /* Deskripsi full width */

    .form-group:last-of-type {
        grid-column: 1 / -1;
    }


    /* =====================================================
       FORM ACTIONS
       ===================================================== */

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 22px;
        margin-top: 2px;
        border-top: 1px solid #292d35;
    }


    /* =====================================================
       BUTTON
       ===================================================== */

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-primary {
        border: 1px solid #f3f4f6;
        background: #f3f4f6;
        color: #111827;
    }

    .btn-primary:hover {
        background: #ffffff;
        border-color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: transparent;
        border: 1px solid #363b45;
        color: #9ca3af;
    }

    .btn-secondary:hover {
        background: #20232a;
        border-color: #4b5563;
        color: #f3f4f6;
    }


    /* =====================================================
       RESPONSIVE
       ===================================================== */

    @media (max-width: 900px) {

        .sidebar {
            width: 200px;
        }

        .main {
            margin-left: 200px;
            width: calc(100% - 200px);
        }

        .content-container {
            padding: 25px;
        }

        .data-form {
            grid-template-columns: 1fr;
        }

        .form-group:last-of-type,
        .form-actions {
            grid-column: auto;
        }

    }


    @media (max-width: 650px) {

        .sidebar {
            display: none;
        }

        .main {
            margin-left: 0;
            width: 100%;
        }

        .topbar {
            padding: 0 20px;
        }

        .content-container {
            padding: 20px;
        }

        .data-card-content {
            padding: 20px;
        }

    }

</style>

</head>


<body>

<div class="app">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-mark"></div>

            <span>
                Gadget Store
            </span>

        </div>


        <div class="nav-title">
            Main Menu
        </div>


        <a
            href="../dashboard.php"
            class="nav-link"
        >
            Dashboard
        </a>


        <a
            href="index.php"
            class="nav-link active"
        >
            Data Gadget
        </a>


        <a
            href="../categories/index.php"
            class="nav-link"
        >
            Data Kategori
        </a>


        <a
            href="../customers/index.php"
            class="nav-link"
        >
            Data Pelanggan
        </a>


        <a
            href="../users/index.php"
            class="nav-link"
        >
            Data User
        </a>


        <div class="nav-title">
            Transaksi
        </div>


        <a
            href="../transactions/index.php"
            class="nav-link"
        >
            Transaksi
        </a>


        <div class="nav-title">
            Account
        </div>


        <a
            href="../../auth/logout.php"
            class="nav-link"
        >
            Logout
        </a>

    </aside>



    <!-- =====================================================
         MAIN
         ===================================================== -->

    <main class="main">


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h1 class="page-title">
                    Tambah Gadget
                </h1>

                <p class="page-subtitle">
                    Tambahkan data gadget baru ke Gadget Store
                </p>

            </div>


            <div class="user-box">

                <div class="avatar">

                    <?php

                    echo strtoupper(
                        substr(
                            $_SESSION['name'],
                            0,
                            1
                        )
                    );

                    ?>

                </div>


                <div>

                    <div class="user-name">

                        <?php

                        echo htmlspecialchars(
                            $_SESSION['name']
                        );

                        ?>

                    </div>


                    <div class="user-role">

                        <?php

                        echo htmlspecialchars(
                            $_SESSION['role']
                        );

                        ?>

                    </div>

                </div>

            </div>

        </div>



        <!-- CONTENT -->

        <div class="content-container">

            <div class="data-card">


                <!-- CARD HEADER -->

                <div class="data-card-header">

                    <div class="data-card-title">
                        Form Tambah Gadget
                    </div>

                </div>



                <!-- FORM -->

                <div class="data-card-content">

                    <form
                        action="proses.php"
                        method="POST"
                        class="data-form"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="tambah"
                        >


                        <div class="form-group">

                            <label for="name">
                                Nama Gadget
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Contoh: iPhone 17 Pro"
                                required
                            >

                        </div>



                        <div class="form-group">

                            <label for="brand">
                                Brand
                            </label>

                            <input
                                type="text"
                                id="brand"
                                name="brand"
                                placeholder="Contoh: Apple"
                                required
                            >

                        </div>



                        <div class="form-group">

                            <label for="category_id">
                                Kategori
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                required
                            >

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                <?php while ($category = mysqli_fetch_assoc($result)): ?>

                                    <option
                                        value="<?php echo $category['id']; ?>"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $category['name']
                                        );

                                        ?>

                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>



                        <div class="form-group">

                            <label for="price">
                                Harga
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                min="0"
                                placeholder="Contoh: 15000000"
                                required
                            >

                        </div>



                        <div class="form-group">

                            <label for="stock">
                                Stok
                            </label>

                            <input
                                type="number"
                                id="stock"
                                name="stock"
                                min="0"
                                placeholder="Contoh: 10"
                                required
                            >

                        </div>



                        <div class="form-group">

                            <label for="description">
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Masukkan deskripsi gadget..."
                            ></textarea>

                        </div>



                        <div class="form-actions">

                            <a
                                href="index.php"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan Gadget
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </main>

</div>

</body>

</html>