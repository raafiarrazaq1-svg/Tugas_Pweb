<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$id = (int) $id;


/*
|--------------------------------------------------------------------------
| Ambil data transaksi
|--------------------------------------------------------------------------
*/

$query = "SELECT *
          FROM transactions
          WHERE id = ?
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


/*
|--------------------------------------------------------------------------
| Cek transaksi
|--------------------------------------------------------------------------
*/

if (!$transaction) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Cek status transaksi
|--------------------------------------------------------------------------
*/

if ($transaction['transaction_status'] !== 'berjalan') {
    header("Location: detail.php?id=" . $id);
    exit;
}


/*
|--------------------------------------------------------------------------
| Tampilkan form penyelesaian
|--------------------------------------------------------------------------
*/

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
        Penyelesaian Transaksi - Gadget Store
    </title>

</head>

<body>

    <h1>Penyelesaian Transaksi</h1>

    <p>
        <strong>Kode Transaksi:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['transaction_code']
        );
        ?>
    </p>

    <p>
        <strong>Total:</strong>

        Rp
        <?php
        echo number_format(
            $transaction['total'],
            0,
            ',',
            '.'
        );
        ?>
    </p>

    <p>
        <strong>Status Pembayaran Saat Ini:</strong>

        <?php
        echo htmlspecialchars(
            $transaction['payment_status']
        );
        ?>
    </p>


    <form action="proses.php" method="POST">

        <input
            type="hidden"
            name="action"
            value="selesai"
        >

        <input
            type="hidden"
            name="id"
            value="<?php echo $transaction['id']; ?>"
        >

        <p>
            Apakah transaksi ini sudah dilunasi dan ingin diselesaikan?
        </p>

        <button type="submit">
            Selesaikan Transaksi
        </button>

        <a href="detail.php?id=<?php echo $transaction['id']; ?>">
            Batal
        </a>

    </form>

</body>

</html>