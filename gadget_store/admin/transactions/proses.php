<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";


/*
|--------------------------------------------------------------------------
| CEK REQUEST
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? '';



/*
|--------------------------------------------------------------------------
| TAMBAH TRANSAKSI
|--------------------------------------------------------------------------
*/

if ($action === 'tambah') {

    $customer_id = $_POST['customer_id'] ?? '';

    $gadget_ids = $_POST['gadget_id'] ?? [];

    $quantities = $_POST['quantity'] ?? [];


    /*
    |--------------------------------------------------------------------------
    | Validasi data awal
    |--------------------------------------------------------------------------
    */

    if (
        !is_numeric($customer_id) ||
        empty($gadget_ids) ||
        empty($quantities)
    ) {
        header("Location: tambah.php");
        exit;
    }


    if (count($gadget_ids) !== count($quantities)) {
        header("Location: tambah.php");
        exit;
    }


    $customer_id = (int) $customer_id;

    $user_id = (int) $_SESSION['user_id'];


    /*
    |--------------------------------------------------------------------------
    | Mulai transaksi database
    |--------------------------------------------------------------------------
    */

    mysqli_begin_transaction($conn);


    try {

        /*
        |--------------------------------------------------------------------------
        | CEK PELANGGAN
        |--------------------------------------------------------------------------
        */

        $customer_query =
            "SELECT id
             FROM customers
             WHERE id = ?
             LIMIT 1";


        $customer_stmt =
            mysqli_prepare(
                $conn,
                $customer_query
            );


        mysqli_stmt_bind_param(
            $customer_stmt,
            "i",
            $customer_id
        );


        mysqli_stmt_execute(
            $customer_stmt
        );


        $customer_result =
            mysqli_stmt_get_result(
                $customer_stmt
            );


        if (!mysqli_fetch_assoc($customer_result)) {

            throw new Exception(
                "Pelanggan tidak ditemukan."
            );

        }



        /*
        |--------------------------------------------------------------------------
        | Siapkan detail transaksi
        |--------------------------------------------------------------------------
        */

        $details = [];

        $total = 0;


        /*
        |--------------------------------------------------------------------------
        | Periksa setiap gadget
        |--------------------------------------------------------------------------
        */

        for (
            $i = 0;
            $i < count($gadget_ids);
            $i++
        ) {

            $gadget_id =
                (int) $gadget_ids[$i];


            $quantity =
                (int) $quantities[$i];


            if (
                $gadget_id <= 0 ||
                $quantity <= 0
            ) {

                throw new Exception(
                    "Data gadget tidak valid."
                );

            }



            /*
            |--------------------------------------------------------------------------
            | Ambil data gadget
            |--------------------------------------------------------------------------
            */

            $gadget_query =
                "SELECT
                    id,
                    name,
                    price,
                    stock
                 FROM gadgets
                 WHERE id = ?
                 FOR UPDATE";


            $gadget_stmt =
                mysqli_prepare(
                    $conn,
                    $gadget_query
                );


            mysqli_stmt_bind_param(
                $gadget_stmt,
                "i",
                $gadget_id
            );


            mysqli_stmt_execute(
                $gadget_stmt
            );


            $gadget_result =
                mysqli_stmt_get_result(
                    $gadget_stmt
                );


            $gadget =
                mysqli_fetch_assoc(
                    $gadget_result
                );


            if (!$gadget) {

                throw new Exception(
                    "Gadget tidak ditemukan."
                );

            }



            /*
            |--------------------------------------------------------------------------
            | Cek stok
            |--------------------------------------------------------------------------
            */

            if (
                $quantity >
                $gadget['stock']
            ) {

                throw new Exception(
                    "Stok gadget "
                    . $gadget['name']
                    . " tidak mencukupi."
                );

            }



            /*
            |--------------------------------------------------------------------------
            | Hitung subtotal
            |--------------------------------------------------------------------------
            */

            $price =
                (float) $gadget['price'];


            $subtotal =
                $price * $quantity;


            $total += $subtotal;



            /*
            |--------------------------------------------------------------------------
            | Simpan sementara detail
            |--------------------------------------------------------------------------
            */

            $details[] = [

                'gadget_id' =>
                    $gadget_id,

                'quantity' =>
                    $quantity,

                'price' =>
                    $price,

                'subtotal' =>
                    $subtotal

            ];

        }



        /*
        |--------------------------------------------------------------------------
        | Buat kode transaksi
        |--------------------------------------------------------------------------
        */

        $transaction_code =
            'TRX-'
            . date('YmdHis')
            . '-'
            . rand(100, 999);



        /*
        |--------------------------------------------------------------------------
        | Simpan transaksi utama
        |--------------------------------------------------------------------------
        */

        $transaction_query =
            "INSERT INTO transactions
            (
                transaction_code,
                customer_id,
                user_id,
                total,
                payment_status,
                transaction_status
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                'belum_lunas',
                'berjalan'
            )";


        $transaction_stmt =
            mysqli_prepare(
                $conn,
                $transaction_query
            );


        mysqli_stmt_bind_param(
            $transaction_stmt,
            "siid",
            $transaction_code,
            $customer_id,
            $user_id,
            $total
        );


        mysqli_stmt_execute(
            $transaction_stmt
        );


        $transaction_id =
            mysqli_insert_id($conn);



        /*
        |--------------------------------------------------------------------------
        | Simpan detail transaksi dan kurangi stok
        |--------------------------------------------------------------------------
        */

        foreach ($details as $detail) {

            $gadget_id =
                $detail['gadget_id'];


            $quantity =
                $detail['quantity'];


            $price =
                $detail['price'];


            $subtotal =
                $detail['subtotal'];



            /*
            | Simpan detail transaksi
            */

            $detail_query =
                "INSERT INTO transaction_details
                (
                    transaction_id,
                    gadget_id,
                    quantity,
                    price,
                    subtotal
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )";


            $detail_stmt =
                mysqli_prepare(
                    $conn,
                    $detail_query
                );


            mysqli_stmt_bind_param(
                $detail_stmt,
                "iiidd",
                $transaction_id,
                $gadget_id,
                $quantity,
                $price,
                $subtotal
            );


            mysqli_stmt_execute(
                $detail_stmt
            );



            /*
            | Kurangi stok gadget
            */

            $stock_query =
                "UPDATE gadgets
                 SET stock = stock - ?
                 WHERE id = ?
                 AND stock >= ?";


            $stock_stmt =
                mysqli_prepare(
                    $conn,
                    $stock_query
                );


            mysqli_stmt_bind_param(
                $stock_stmt,
                "iii",
                $quantity,
                $gadget_id,
                $quantity
            );


            mysqli_stmt_execute(
                $stock_stmt
            );


            if (
                mysqli_stmt_affected_rows(
                    $stock_stmt
                ) !== 1
            ) {

                throw new Exception(
                    "Gagal memperbarui stok gadget."
                );

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Simpan semua perubahan
        |--------------------------------------------------------------------------
        */

        mysqli_commit($conn);


        header(
            "Location: detail.php?id="
            . $transaction_id
        );

        exit;


    } catch (Exception $e) {


        /*
        |--------------------------------------------------------------------------
        | Batalkan jika terjadi kesalahan
        |--------------------------------------------------------------------------
        */

        mysqli_rollback($conn);


        die(
            "Transaksi gagal: "
            . htmlspecialchars(
                $e->getMessage()
            )
        );

    }

}



/*
|--------------------------------------------------------------------------
| SELESAIKAN TRANSAKSI
|--------------------------------------------------------------------------
*/

if ($action === 'selesai') {

    $id = $_POST['id'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | Validasi ID
    |--------------------------------------------------------------------------
    */

    if (!is_numeric($id)) {

        header("Location: index.php");

        exit;

    }


    $id = (int) $id;



    /*
    |--------------------------------------------------------------------------
    | Ambil transaksi
    |--------------------------------------------------------------------------
    */

    $query =
        "SELECT
            id,
            transaction_status
         FROM transactions
         WHERE id = ?
         LIMIT 1";


    $stmt =
        mysqli_prepare(
            $conn,
            $query
        );


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    $transaction =
        mysqli_fetch_assoc(
            $result
        );



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
    | Pastikan transaksi masih berjalan
    |--------------------------------------------------------------------------
    */

    if (
        $transaction['transaction_status']
        !== 'berjalan'
    ) {

        header(
            "Location: detail.php?id="
            . $id
        );

        exit;

    }



    /*
    |--------------------------------------------------------------------------
    | Ubah status transaksi
    |--------------------------------------------------------------------------
    */

    $update_query =
        "UPDATE transactions
         SET
            payment_status = 'lunas',
            transaction_status = 'selesai'
         WHERE id = ?
         AND transaction_status = 'berjalan'";


    $update_stmt =
        mysqli_prepare(
            $conn,
            $update_query
        );


    mysqli_stmt_bind_param(
        $update_stmt,
        "i",
        $id
    );


    mysqli_stmt_execute(
        $update_stmt
    );



    /*
    |--------------------------------------------------------------------------
    | Kembali ke detail transaksi
    |--------------------------------------------------------------------------
    */

    header(
        "Location: detail.php?id="
        . $id
    );

    exit;

}



/*
|--------------------------------------------------------------------------
| Jika action tidak dikenali
|--------------------------------------------------------------------------
*/

header("Location: index.php");

exit;