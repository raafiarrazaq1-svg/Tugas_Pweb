<?php

session_start();

require_once "../config/database.php";


/*
|--------------------------------------------------------------------------
| CEK REQUEST
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: login.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| AMBIL DATA LOGIN
|--------------------------------------------------------------------------
*/

$username = $_POST['username'] ?? '';

$password = $_POST['password'] ?? '';


/*
|--------------------------------------------------------------------------
| VALIDASI INPUT
|--------------------------------------------------------------------------
*/

if (
    empty($username) ||
    empty($password)
) {

    header(
        "Location: login.php?error=empty"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CARI USER
|--------------------------------------------------------------------------
*/

$query =
    "SELECT
        id,
        name,
        username,
        password,
        role
     FROM users
     WHERE username = ?
     LIMIT 1";


$stmt =
    mysqli_prepare(
        $conn,
        $query
    );


mysqli_stmt_bind_param(
    $stmt,
    "s",
    $username
);


mysqli_stmt_execute(
    $stmt
);


$result =
    mysqli_stmt_get_result(
        $stmt
    );


$user =
    mysqli_fetch_assoc(
        $result
    );


/*
|--------------------------------------------------------------------------
| CEK USER DAN PASSWORD
|--------------------------------------------------------------------------
*/

if (
    !$user ||
    !password_verify(
        $password,
        $user['password']
    )
) {

    header(
        "Location: login.php?error=invalid"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| SIMPAN SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['user_id'] =
    $user['id'];

$_SESSION['name'] =
    $user['name'];

$_SESSION['username'] =
    $user['username'];

$_SESSION['role'] =
    $user['role'];


/*
|--------------------------------------------------------------------------
| REDIRECT BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/

if ($user['role'] === 'admin') {

    header(
        "Location: ../admin/dashboard.php"
    );

    exit;
}


if ($user['role'] === 'user') {

    header(
        "Location: ../user/dashboard.php"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| ROLE TIDAK DIKENALI
|--------------------------------------------------------------------------
*/

session_unset();

session_destroy();

header(
    "Location: login.php?error=role"
);

exit;