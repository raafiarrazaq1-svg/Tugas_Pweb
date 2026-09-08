<?php

require_once "../../includes/admin_auth.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Gadget Store</title>
</head>
<body>

    <h1>Tambah User</h1>

    <form action="proses.php" method="POST">

        <input
            type="hidden"
            name="action"
            value="tambah"
        >

        <div>
            <label>Nama</label>
            <br>

            <input
                type="text"
                name="name"
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
                required
            >
        </div>

        <br>

        <div>
            <label>Password</label>
            <br>

            <input
                type="password"
                name="password"
                required
            >
        </div>

        <br>

        <div>
            <label>Role</label>
            <br>

            <select name="role" required>

                <option value="">
                    -- Pilih Role --
                </option>

                <option value="admin">
                    Admin
                </option>

                <option value="user">
                    User
                </option>

            </select>

        </div>

        <br>

        <button type="submit">
            Simpan
        </button>

        <a href="index.php">
            Kembali
        </a>

    </form>

</body>
</html>