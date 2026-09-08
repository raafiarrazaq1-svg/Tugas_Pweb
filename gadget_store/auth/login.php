<?php

session_start();

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] === 'admin_auth') {
        header("Location: ../admin/dashboard.php");
        exit;
    }

    if ($_SESSION['role'] === 'user') {
        header("Location: ../user/dashboard.php");
        exit;
    }
}

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
        Login - Gadget Store
    </title>

    <!-- CSS -->
    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body class="login-page">


    <div class="login-container">


        <div class="login-card">


            <!-- LOGO -->
            <div class="login-logo">

                <div class="logo-mark"></div>

                <span>
                    Gadget Store
                </span>

            </div>


            <!-- TITLE -->
            <div class="login-header">

                <h1>
                    Login
                </h1>

                <p>
                    Masuk ke sistem Gadget Store
                </p>

            </div>


            <!-- ERROR -->
            <?php if (isset($_GET['error'])): ?>

                <div class="login-error">

                    <?php
                    echo htmlspecialchars(
                        $_GET['error']
                    );
                    ?>

                </div>

            <?php endif; ?>


            <!-- FORM -->
            <form
                action="proses_login.php"
                method="POST"
                class="login-form"
            >


                <!-- USERNAME -->
                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukkan username"
                        required
                    >

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                </div>


                <!-- BUTTON -->
                <button
                    type="submit"
                    class="btn btn-primary login-button"
                >
                    Login
                </button>


            </form>


        </div>


    </div>


</body>

</html>