<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";


$query = "SELECT gadgets.*, categories.name AS category_name
          FROM gadgets
          INNER JOIN categories
          ON gadgets.category_id = categories.id
          ORDER BY gadgets.id DESC";

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

    <title>
        Data Gadget - Gadget Store
    </title>

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


        <!-- HEADER -->

        <div class="topbar">


            <div>

                <h1 class="page-title">
                    Data Gadget
                </h1>

                <p class="page-subtitle">
                    Kelola data gadget pada Gadget Store
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
                            Daftar Gadget
                        </div>

                    </div>


                    <a
                        href="tambah.php"
                        class="btn btn-primary"
                    >
                        + Tambah Gadget
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
                                        Nama Gadget
                                    </th>

                                    <th>
                                        Brand
                                    </th>

                                    <th>
                                        Kategori
                                    </th>

                                    <th>
                                        Harga
                                    </th>

                                    <th>
                                        Stok
                                    </th>

                                    <th>
                                        Deskripsi
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
                                $gadget =
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
                                                $gadget['name']
                                            );

                                            ?>

                                        </span>

                                    </td>



                                    <!-- BRAND -->

                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $gadget['brand']
                                        );

                                        ?>

                                    </td>



                                    <!-- KATEGORI -->

                                    <td>

                                        <span class="data-secondary">

                                            <?php

                                            echo htmlspecialchars(
                                                $gadget['category_name']
                                            );

                                            ?>

                                        </span>

                                    </td>



                                    <!-- HARGA -->

                                    <td>

                                        <span class="price">

                                            Rp

                                            <?php

                                            echo number_format(
                                                $gadget['price'],
                                                0,
                                                ',',
                                                '.'
                                            );

                                            ?>

                                        </span>

                                    </td>



                                    <!-- STOK -->

                                    <td>


                                        <?php

                                        if (
                                            $gadget['stock'] <= 0
                                        ):

                                        ?>

                                            <span
                                                class="stock stock-empty"
                                            >
                                                Habis
                                            </span>


                                        <?php

                                        elseif (
                                            $gadget['stock'] <= 5
                                        ):

                                        ?>

                                            <span
                                                class="stock stock-low"
                                            >

                                                <?php

                                                echo $gadget['stock'];

                                                ?>

                                            </span>


                                        <?php else: ?>


                                            <span
                                                class="stock stock-available"
                                            >

                                                <?php

                                                echo $gadget['stock'];

                                                ?>

                                            </span>


                                        <?php endif; ?>


                                    </td>



                                    <!-- DESKRIPSI -->

                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $gadget['description']
                                        );

                                        ?>

                                    </td>



                                    <!-- AKSI -->

                                    <td>


                                        <div class="table-actions">


                                            <a
                                                href="edit.php?id=<?php echo $gadget['id']; ?>"
                                                class="btn action-edit"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="hapus.php?id=<?php echo $gadget['id']; ?>"
                                                class="btn action-delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus gadget ini?')"
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