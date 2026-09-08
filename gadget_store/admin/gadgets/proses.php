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
| TAMBAH GADGET
|--------------------------------------------------------------------------
*/

if ($action === 'tambah') {

    $name = trim($_POST['name'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if (
        $name === '' ||
        $brand === '' ||
        !is_numeric($category_id) ||
        !is_numeric($price) ||
        !is_numeric($stock)
    ) {
        header("Location: tambah.php");
        exit;
    }

    $query = "INSERT INTO gadgets
              (category_id, name, brand, price, stock, description)
              VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "issdis",
        $category_id,
        $name,
        $brand,
        $price,
        $stock,
        $description
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| EDIT GADGET
|--------------------------------------------------------------------------
*/

if ($action === 'edit') {

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if (
        !is_numeric($id) ||
        $name === '' ||
        $brand === '' ||
        !is_numeric($category_id) ||
        !is_numeric($price) ||
        !is_numeric($stock)
    ) {
        header("Location: index.php");
        exit;
    }

    $query = "UPDATE gadgets
              SET category_id = ?,
                  name = ?,
                  brand = ?,
                  price = ?,
                  stock = ?,
                  description = ?
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "issdisi",
        $category_id,
        $name,
        $brand,
        $price,
        $stock,
        $description,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


header("Location: index.php");
exit;