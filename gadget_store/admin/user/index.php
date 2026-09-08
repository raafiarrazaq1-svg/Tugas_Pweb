<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$query = "SELECT id, name, username, role, created_at
          FROM users
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - Gadget Store</title>
</head>
<body>

    <h1>Data User</h1>

    <p>
        Selamat datang,
        <?php echo htmlspecialchars($_SESSION['name']); ?>
    </p>

    <a href="../dashboard.php">Dashboard</a>
    |
    <a href="tambah.php">Tambah User</a>
    |
    <a href="../../auth/logout.php">Logout</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $no = 1;

        while ($user = mysqli_fetch_assoc($result)):
        ?>

            <tr>

                <td>
                    <?php echo $no++; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($user['name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($user['username']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($user['role']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($user['created_at']); ?>
                </td>

                <td>

                    <a href="edit.php?id=<?php echo $user['id']; ?>">
                        Edit
                    </a>

                    |

                    <a
                        href="hapus.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                    >
                        Hapus
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</body>
</html>