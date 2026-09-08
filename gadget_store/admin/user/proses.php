<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? '';


/*
|--------------------------------------------------------------------------
| TAMBAH USER
|--------------------------------------------------------------------------
*/

if ($action === 'tambah') {

    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (
        $name === '' ||
        $username === '' ||
        $password === '' ||
        !in_array($role, ['admin', 'user'], true)
    ) {
        header("Location: tambah.php");
        exit;
    }

    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $query = "INSERT INTO users
              (name, username, password, role)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $name,
        $username,
        $password_hash,
        $role
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| EDIT USER
|--------------------------------------------------------------------------
*/

if ($action === 'edit') {

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (
        !is_numeric($id) ||
        $name === '' ||
        $username === '' ||
        !in_array($role, ['admin', 'user'], true)
    ) {
        header("Location: index.php");
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Jika password diisi, password akan diubah
    |--------------------------------------------------------------------------
    */

    if ($password !== '') {

        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = "UPDATE users
                  SET name = ?,
                      username = ?,
                      password = ?,
                      role = ?
                  WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $name,
            $username,
            $password_hash,
            $role,
            $id
        );

    } else {

        /*
        |--------------------------------------------------------------------------
        | Jika password kosong, password lama tetap digunakan
        |--------------------------------------------------------------------------
        */

        $query = "UPDATE users
                  SET name = ?,
                      username = ?,
                      role = ?
                  WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $name,
            $username,
            $role,
            $id
        );
    }

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}


header("Location: index.php");
exit;