<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$query = "DELETE FROM categories WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;