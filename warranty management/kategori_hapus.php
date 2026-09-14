<?php

session_start();
require_once "database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = (int) $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM kategori WHERE id = $id"
);

header("Location: kategori.php");
exit;