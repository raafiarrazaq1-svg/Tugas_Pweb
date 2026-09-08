<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? '';


/*
|--------------------------------------------------------------------------
| TAMBAH PELANGGAN
|--------------------------------------------------------------------------
*/

if ($action === 'tambah') {

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (
        $name === '' ||
        $phone === '' ||
        $address === ''
    ) {
        header("Location: tambah.php");
        exit;
    }

    $query = "INSERT INTO customers
              (name, phone, address)
              VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $name,
        $phone,
        $address
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| EDIT PELANGGAN
|--------------------------------------------------------------------------
*/

if ($action === 'edit') {

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (
        !is_numeric($id) ||
        $name === '' ||
        $phone === '' ||
        $address === ''
    ) {
        header("Location: index.php");
        exit;
    }

    $query = "UPDATE customers
              SET name = ?,
                  phone = ?,
                  address = ?
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $name,
        $phone,
        $address,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


header("Location: index.php");
exit;