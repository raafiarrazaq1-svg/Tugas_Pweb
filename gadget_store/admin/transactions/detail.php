<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}


$query = "SELECT
            transactions.*,
            customers.name AS customer_name,
            customers.phone AS customer_phone,
            customers.address AS customer_address,
            users.name AS user_name
          FROM transactions
          INNER JOIN customers
            ON transactions.customer_id = customers.id
          INNER JOIN users
            ON transactions.user_id = users.id
          WHERE transactions.id = ?
          LIMIT 1";


$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$transaction = mysqli_fetch_assoc($result);


if (!$transaction) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Detail transaksi
|--------------------------------------------------------------------------
*/

$detail_query =
    "SELECT
        transaction_details.*,
        gadgets.name AS gadget_name,
        gadgets.brand AS gadget_brand
     FROM transaction_details
     INNER JOIN gadgets
        ON transaction_details.gadget_id = gadgets.id
     WHERE transaction_details.transaction_id = ?
     ORDER BY transaction_details.id ASC";


$detail_stmt =
    mysqli_prepare(
        $conn,
        $detail_query
    );


mysqli_stmt_bind_param(
    $detail_stmt,
    "i",
    $id
);


mysqli_stmt_execute($detail_stmt);


$detail_result =
    mysqli_stmt_get_result($detail_stmt);

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
        Detail Transaksi - Gadget Store
    </title>

</head>

<body>

    <h1>Detail Transaksi</h1>

    <p>
        <strong>Kode Transaksi:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['transaction_code']
        );
        ?>
    </p>

    <p>
        <strong>Pelanggan:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['customer_name']
        );
        ?>
    </p>

    <p>
        <strong>No. Telepon:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['customer_phone']
        );
        ?>
    </p>

    <p>
        <strong>Alamat:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['customer_address']
        );
        ?>
    </p>

    <p>
        <strong>Petugas:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['user_name']
        );
        ?>
    </p>

    <p>
        <strong>Tanggal:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['transaction_date']
        );
        ?>
    </p>

    <p>
        <strong>Pembayaran:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['payment_status']
        );
        ?>
    </p>

    <p>
        <strong>Status Transaksi:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['transaction_status']
        );
        ?>
    </p>


    <h3>Detail Gadget</h3>

    <table
        border="1"
        cellpadding="10"
        cellspacing="0"
    >

        <thead>

            <tr>

                <th>No</th>
                <th>Gadget</th>
                <th>Brand</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>

            </tr>

        </thead>

        <tbody>

        <?php

        $no = 1;

        while (
            $detail =
            mysqli_fetch_assoc($detail_result)
        ):

        ?>

            <tr>

                <td>
                    <?php echo $no++; ?>
                </td>

                <td>
                    <?php
                    echo htmlspecialchars(
                        $detail['gadget_name']
                    );
                    ?>
                </td>

                <td>
                    <?php
                    echo htmlspecialchars(
                        $detail['gadget_brand']
                    );
                    ?>
                </td>

                <td>
                    Rp
                    <?php
                    echo number_format(
                        $detail['price'],
                        0,
                        ',',
                        '.'
                    );
                    ?>
                </td>

                <td>
                    <?php
                    echo $detail['quantity'];
                    ?>
                </td>

                <td>
                    Rp
                    <?php
                    echo number_format(
                        $detail['subtotal'],
                        0,
                        ',',
                        '.'
                    );
                    ?>
                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

    <br>

    <h2>
        Total:
        Rp
        <?php
        echo number_format(
            $transaction['total'],
            0,
            ',',
            '.'
        );
        ?>
    </h2>


    <?php if ($transaction['transaction_status'] === 'berjalan'): ?>

        <a href="selesai.php?id=<?php echo $transaction['id']; ?>">
            Selesaikan Transaksi
        </a>

        <br><br>

    <?php endif; ?>


    <a href="index.php">
        Kembali
    </a>

</body>

</html>