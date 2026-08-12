<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h2>Login</h2>
        
        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<p style='color: #d9534f; text-align: center; font-weight: bold;'>Username atau Password salah!</p>";
            } else if($_GET['pesan'] == "belum_login"){
                echo "<p style='color: #f0ad4e; text-align: center; font-weight: bold;'>Silakan login terlebih dahulu untuk mengakses data.</p>";
            }
        }
        ?>

        <form action="login_aksi.php" method="POST" class="form-crud">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-tambah" style="width: 100%;">Login</button>
        </form>
    </div>
</body>
</html>