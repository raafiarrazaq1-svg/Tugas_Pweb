<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$query = "SELECT * FROM gadgets WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$gadget = mysqli_fetch_assoc($result);

if (!$gadget) {
    header("Location: index.php");
    exit;
}


$category_query = "SELECT * FROM categories ORDER BY name ASC";

$category_result = mysqli_query($conn, $category_query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gadget - Gadget Store</title>
</head>
<body>

    <h1>Edit Gadget</h1>

    <form action="proses.php" method="POST">

        <input type="hidden" name="action" value="edit">

        <input
            type="hidden"
            name="id"
            value="<?php echo $gadget['id']; ?>"
        >

        <div>
            <label>Nama Gadget</label>
            <br>

            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($gadget['name']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Brand</label>
            <br>

            <input
                type="text"
                name="brand"
                value="<?php echo htmlspecialchars($gadget['brand']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Kategori</label>
            <br>

            <select name="category_id" required>

                <?php while ($category = mysqli_fetch_assoc($category_result)): ?>

                    <option
                        value="<?php echo $category['id']; ?>"
                        <?php
                        if ($category['id'] == $gadget['category_id']) {
                            echo 'selected';
                        }
                        ?>
                    >
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <br>

        <div>
            <label>Harga</label>
            <br>

            <input
                type="number"
                name="price"
                min="0"
                value="<?php echo $gadget['price']; ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Stok</label>
            <br>

            <input
                type="number"
                name="stock"
                min="0"
                value="<?php echo $gadget['stock']; ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Deskripsi</label>
            <br>

            <textarea
                name="description"
                rows="5"
            ><?php echo htmlspecialchars($gadget['description']); ?></textarea>
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