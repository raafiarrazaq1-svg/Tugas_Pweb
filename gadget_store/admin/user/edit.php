<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$query = "SELECT id, name, username, role
          FROM users
          WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Gadget Store</title>
</head>
<body>

    <h1>Edit User</h1>

    <form action="proses.php" method="POST">

        <input
            type="hidden"
            name="action"
            value="edit"
        >

        <input
            type="hidden"
            name="id"
            value="<?php echo $user['id']; ?>"
        >

        <div>
            <label>Nama</label>
            <br>

            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($user['name']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Username</label>
            <br>

            <input
                type="text"
                name="username"
                value="<?php echo htmlspecialchars($user['username']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label>Password Baru</label>
            <br>

            <input
                type="password"
                name="password"
            >

            <br>

            <small>
                Kosongkan jika password tidak ingin diubah.
            </small>
        </div>

        <br>

        <div>
            <label>Role</label>
            <br>

            <select name="role" required>

                <option
                    value="admin"
                    <?php
                    if ($user['role'] === 'admin') {
                        echo 'selected';
                    }
                    ?>
                >
                    Admin
                </option>

                <option
                    value="user"
                    <?php
                    if ($user['role'] === 'user') {
                        echo 'selected';
                    }
                    ?>
                >
                    User
                </option>

            </select>

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