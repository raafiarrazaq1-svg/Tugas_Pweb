<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$query = "SELECT * FROM customers WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - Gadget Store</title>
</head>
<body>

    <h1>Edit Pelanggan</h1>

    <form action="proses.php" method="POST">

        <input
            type="hidden"
            name="action"
            value="edit"
        >

        <input
            type="hidden"
            name="id"
            value="<?php echo $customer['id']; ?>"
        >

        <div>
            <label>Nama</label>
            <br>

            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($customer['name']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>No. Telepon</label>
            <br>

            <input
                type="text"
                name="phone"
                value="<?php echo htmlspecialchars($customer['phone']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Alamat</label>
            <br>

            <textarea
                name="address"
                rows="5"
                required
            ><?php echo htmlspecialchars($customer['address']); ?></textarea>
        </div>

        <br>

        <button type="submit">
            Simpan Perubahan
        </button>

        <a href="index.php">
            Kembali
        </a>

    </form>

</body>
</html>