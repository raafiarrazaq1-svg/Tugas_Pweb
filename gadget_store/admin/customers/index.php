<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$query = "SELECT * FROM customers ORDER BY id DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Gadget Store</title>

    <!-- CSS -->
    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >
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
            href="../gadgets/index.php"
            class="nav-link"
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
            href="index.php"
            class="nav-link active"
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

        <!-- HEADER -->
        <div class="topbar">

            <div>

                <h1 class="page-title">
                    Data Pelanggan
                </h1>

                <p class="page-subtitle">
                    Kelola data pelanggan pada Gadget Store
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


        <!-- =================================================
             CONTENT
             ================================================= -->
        <div class="content-container">

            <div class="data-card">

                <!-- CARD HEADER -->
                <div class="data-card-header">

                    <div>

                        <div class="data-card-title">
                            Daftar Pelanggan
                        </div>

                    </div>


                    <a
                        href="tambah.php"
                        class="btn btn-primary"
                    >
                        + Tambah Pelanggan
                    </a>

                </div>


                <!-- TABLE -->
                <div class="data-card-content">

                    <div class="table-wrapper">

                        <table class="data-table">

                            <thead>

                                <tr>

                                    <th>
                                        No
                                    </th>

                                    <th>
                                        Nama
                                    </th>

                                    <th>
                                        No. Telepon
                                    </th>

                                    <th>
                                        Alamat
                                    </th>

                                    <th>
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                            <?php
                            $no = 1;

                            while (
                                $customer =
                                mysqli_fetch_assoc($result)
                            ):
                            ?>

                                <tr>

                                    <!-- NO -->
                                    <td>

                                        <?php
                                        echo $no++;
                                        ?>

                                    </td>


                                    <!-- NAMA -->
                                    <td>

                                        <span class="data-name">

                                            <?php
                                            echo htmlspecialchars(
                                                $customer['name']
                                            );
                                            ?>

                                        </span>

                                    </td>


                                    <!-- TELEPON -->
                                    <td>

                                        <span class="data-secondary">

                                            <?php
                                            echo htmlspecialchars(
                                                $customer['phone']
                                            );
                                            ?>

                                        </span>

                                    </td>


                                    <!-- ALAMAT -->
                                    <td>

                                        <span class="data-secondary">

                                            <?php
                                            echo htmlspecialchars(
                                                $customer['address']
                                            );
                                            ?>

                                        </span>

                                    </td>


                                    <!-- AKSI -->
                                    <td>

                                        <div class="table-actions">

                                            <a
                                                href="edit.php?id=<?php echo $customer['id']; ?>"
                                                class="btn action-edit"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="hapus.php?id=<?php echo $customer['id']; ?>"
                                                class="btn action-delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')"
                                            >
                                                Hapus
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>