<?php

require_once "../includes/user_auth.php";
require_once "../config/database.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard User - Gadget Store
    </title>

</head>

<body>

    <h1>Dashboard User</h1>

    <p>

        Selamat datang,

        <strong>

            <?php
            echo htmlspecialchars(
                $_SESSION['name']
            );
            ?>

        </strong>

    </p>


    <hr>


    <h3>Menu</h3>

    <a href="dashboard.php">
        Dashboard
    </a>

    |

    <a href="../auth/logout.php">
        Logout
    </a>


    <hr>


    <h2>
        Dashboard
    </h2>

    <p>
        Anda berhasil login sebagai pengguna biasa.
    </p>

</body>

</html>