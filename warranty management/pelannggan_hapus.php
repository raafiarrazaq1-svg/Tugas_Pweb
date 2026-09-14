<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "warranty_management");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    header("Location: pelanggan.php");
    exit;
}

$id = (int) $_GET['id'];

$query = "DELETE FROM pelanggan WHERE id = $id";

mysqli_query($conn, $query);

header("Location: pelanggan.php");
exit;