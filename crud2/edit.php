<?php
include "koneksi.php";
$nisn = $_GET['nisn'];
$data = mysqli_query($conn, "SELECT * FROM input WHERE nisn='$nisn'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}
body{
    background-image: url(background.jpg);
    color:black;
}
h2{
    text-align:center;
    margin:30px 0 20px;
    color:#1b4332;
}
form{
    width:700px;
    margin:0 auto;
}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
}
table, th, td{
    border:1px solid #cfcfcf;
}
th{
    background:#1b4332;
    color:white;
}
th,td{
    padding:10px;
    text-align:center;
}
input[type=text],
input[type=date],
input[type=number]{
    width:100%;
    padding:8px;
    margin:5px 0;
    border:1px solid #999;
    border-radius:4px;
}
input:focus{
    outline:none;
    border-color:#1b4332;
}
button{
    background:#1b4332;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:4px;
    cursor:pointer;
}
button:hover{
    background:#000;
}
hr{
    width:700px;
    margin:30px auto;
}
table[border]{
    width:700px;
    margin:0 auto;
}
a{
    text-decoration:none;
    color:#000;
    font-weight:bold;
    margin:0 5px;
}
a:hover{
    color:#1b4332;
}
.edit{
    color:#1b4332;
}
.hapus{
    color:#000;
}
</style>
</head>
<body>
<h2>EDIT DATA</h2>
<form action="update.php" method="POST">
<input type="hidden" name="nisn" value="<?php echo $d['nisn']; ?>">
<table>
    <tr>
        <td>NISN</td>
        <td>
            <input type="number" name="nisn" value="<?php echo $d['nisn']; ?>">
        </td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>
            <input type="text" name="nama" value="<?php echo $d['nama']; ?>">
        </td>
    </tr>
<tr>
    <td>Kelas</td>
    <td>
        <input type="text" name="kelas" value="<?php echo $d['kelas']; ?>">
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <button type="submit" value="Update">Update</button>
    </td>
</tr>
</table>
</form>
</body>
</html>