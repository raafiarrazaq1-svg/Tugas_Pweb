<?php

require_once "../includes/admin_auth.php";
require_once "../config/database.php";


/*
|--------------------------------------------------------------------------
| DATA DASHBOARD
|--------------------------------------------------------------------------
*/

$query_gadgets =
    "SELECT COUNT(*) AS total FROM gadgets";

$result_gadgets =
    mysqli_query($conn, $query_gadgets);

$total_gadgets =
    mysqli_fetch_assoc($result_gadgets)['total'];


$query_stock =
    "SELECT COALESCE(SUM(stock), 0) AS total FROM gadgets";

$result_stock =
    mysqli_query($conn, $query_stock);

$total_stock =
    mysqli_fetch_assoc($result_stock)['total'];


$query_customers =
    "SELECT COUNT(*) AS total FROM customers";

$result_customers =
    mysqli_query($conn, $query_customers);

$total_customers =
    mysqli_fetch_assoc($result_customers)['total'];


$query_transactions =
    "SELECT COUNT(*) AS total FROM transactions";

$result_transactions =
    mysqli_query($conn, $query_transactions);

$total_transactions =
    mysqli_fetch_assoc($result_transactions)['total'];


$query_running =
    "SELECT COUNT(*) AS total
     FROM transactions
     WHERE transaction_status = 'berjalan'";

$result_running =
    mysqli_query($conn, $query_running);

$total_running =
    mysqli_fetch_assoc($result_running)['total'];


$query_completed =
    "SELECT COUNT(*) AS total
     FROM transactions
     WHERE transaction_status = 'selesai'";

$result_completed =
    mysqli_query($conn, $query_completed);

$total_completed =
    mysqli_fetch_assoc($result_completed)['total'];


/*
|--------------------------------------------------------------------------
| TRANSAKSI TERBARU
|--------------------------------------------------------------------------
*/

$query_recent =
    "SELECT
        transactions.id,
        transactions.transaction_code,
        transactions.total,
        transactions.payment_status,
        transactions.transaction_status,
        transactions.transaction_date,
        customers.name AS customer_name
     FROM transactions
     INNER JOIN customers
        ON transactions.customer_id = customers.id
     ORDER BY transactions.id DESC
     LIMIT 5";

$result_recent =
    mysqli_query($conn, $query_recent);

?>

<!DOCTYPE html>

<html lang="id">

<head>

```
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Dashboard - Gadget Store
</title>

<!-- CSS LANGSUNG TERHUBUNG -->
<link
    rel="stylesheet"
    href="../assets/css/style.css"
>
```

</head>

<body>

<div class="app">

```
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
        href="dashboard.php"
        class="nav-link active"
    >
        Dashboard
    </a>


    <a
        href="gadgets/index.php"
        class="nav-link"
    >
        Data Gadget
    </a>


    <a
        href="categories/index.php"
        class="nav-link"
    >
        Data Kategori
    </a>


    <a
        href="customers/index.php"
        class="nav-link"
    >
        Data Pelanggan
    </a>


    <a
        href="users/index.php"
        class="nav-link"
    >
        Data User
    </a>


    <div class="nav-title">
        Transaksi
    </div>


    <a
        href="transactions/index.php"
        class="nav-link"
    >
        Transaksi
    </a>


    <div class="nav-title">
        Account
    </div>


    <a
        href="../auth/logout.php"
        class="nav-link"
    >
        Logout
    </a>


</aside>



<!-- =====================================================
     MAIN CONTENT
     ===================================================== -->

<main class="main">


    <!-- TOPBAR -->

    <div class="topbar">


        <div>

            <h1 class="page-title">
                Dashboard
            </h1>

            <p class="page-subtitle">
                Ringkasan Gadget Store
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
         STATISTICS
         ================================================= -->

    <div class="stats-grid">


        <div class="stat-card">

            <div class="stat-label">
                Total Gadget
            </div>

            <div class="stat-value">

                <?php
                echo $total_gadgets;
                ?>

            </div>

            <div class="stat-description">
                Data gadget
            </div>

        </div>



        <div class="stat-card">

            <div class="stat-label">
                Total Stok
            </div>

            <div class="stat-value">

                <?php
                echo $total_stock;
                ?>

            </div>

            <div class="stat-description">
                Stok tersedia
            </div>

        </div>



        <div class="stat-card">

            <div class="stat-label">
                Total Pelanggan
            </div>

            <div class="stat-value">

                <?php
                echo $total_customers;
                ?>

            </div>

            <div class="stat-description">
                Data pelanggan
            </div>

        </div>



        <div class="stat-card">

            <div class="stat-label">
                Total Transaksi
            </div>

            <div class="stat-value">

                <?php
                echo $total_transactions;
                ?>

            </div>

            <div class="stat-description">
                Seluruh transaksi
            </div>

        </div>


    </div>



    <!-- =================================================
         STATUS TRANSAKSI
         ================================================= -->

    <div class="dashboard-grid">


        <div class="card">


            <div class="card-header">

                <div class="card-title">
                    Status Transaksi
                </div>

            </div>


            <div class="card-body">


                <div class="detail-grid">


                    <div class="detail-item">

                        <div class="detail-label">
                            Berjalan
                        </div>

                        <div class="detail-value">

                            <span
                                class="status status-warning"
                            >

                                <?php
                                echo $total_running;
                                ?>

                                transaksi

                            </span>

                        </div>

                    </div>



                    <div class="detail-item">

                        <div class="detail-label">
                            Selesai
                        </div>

                        <div class="detail-value">

                            <span
                                class="status status-success"
                            >

                                <?php
                                echo $total_completed;
                                ?>

                                transaksi

                            </span>

                        </div>

                    </div>


                </div>


            </div>


        </div>


    </div>



    <br>



    <!-- =================================================
         TRANSAKSI TERBARU
         ================================================= -->

    <div class="card">


        <div class="card-header">


            <div class="card-title">
                Transaksi Terbaru
            </div>


            <a
                href="transactions/index.php"
                class="btn btn-secondary"
            >
                Lihat Semua
            </a>


        </div>



        <div class="table-wrapper">


            <table>


                <thead>

                    <tr>

                        <th>
                            Kode
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Pembayaran
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>



                <tbody>


                <?php

                if (
                    mysqli_num_rows(
                        $result_recent
                    ) > 0
                ):

                ?>


                    <?php

                    while (
                        $transaction =
                        mysqli_fetch_assoc(
                            $result_recent
                        )
                    ):

                    ?>


                    <tr>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $transaction[
                                    'transaction_code'
                                ]
                            );

                            ?>

                        </td>



                        <td>

                            <?php

                            echo htmlspecialchars(
                                $transaction[
                                    'customer_name'
                                ]
                            );

                            ?>

                        </td>



                        <td>

                            <?php

                            echo htmlspecialchars(
                                $transaction[
                                    'transaction_date'
                                ]
                            );

                            ?>

                        </td>



                        <td>

                            Rp

                            <?php

                            echo number_format(
                                $transaction['total'],
                                0,
                                ',',
                                '.'
                            );

                            ?>

                        </td>



                        <td>


                            <?php

                            if (
                                $transaction[
                                    'payment_status'
                                ] === 'lunas'
                            ):

                            ?>

                                <span
                                    class="status status-success"
                                >
                                    Lunas
                                </span>

                            <?php else: ?>

                                <span
                                    class="status status-warning"
                                >
                                    Belum Lunas
                                </span>

                            <?php endif; ?>


                        </td>



                        <td>


                            <?php

                            if (
                                $transaction[
                                    'transaction_status'
                                ] === 'selesai'
                            ):

                            ?>

                                <span
                                    class="status status-success"
                                >
                                    Selesai
                                </span>

                            <?php else: ?>

                                <span
                                    class="status status-warning"
                                >
                                    Berjalan
                                </span>

                            <?php endif; ?>


                        </td>



                        <td>

                            <a
                                href="transactions/detail.php?id=<?php echo $transaction['id']; ?>"
                                class="btn btn-secondary"
                            >
                                Detail
                            </a>

                        </td>


                    </tr>


                    <?php endwhile; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="7"
                            style="text-align:center;"
                        >

                            Belum ada transaksi.

                        </td>

                    </tr>


                <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>


</main>
```

</div>

</body>

</html>
