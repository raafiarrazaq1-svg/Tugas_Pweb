<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'tambah') {

    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        header("Location: tambah.php");
        exit;
    }

    $query = "INSERT INTO categories (name) VALUES (?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $name);

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


if ($action === 'edit') {

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');

    if (!is_numeric($id) || $name === '') {
        header("Location: index.php");
        exit;
    }

    $query = "UPDATE categories
              SET name = ?
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "si", $name, $id);

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;