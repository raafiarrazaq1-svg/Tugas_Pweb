<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>
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
    <h2 align="center" style="color:black">INPUT DATA SISWA</h2>
    <form action="simpan.php" method="POST">    
    <table>
        <tr>
            <td>NISN</td>
            <td>
                <input type="number"name="nisn">
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>
            <input type="text" name="nama">
        </td>
    </tr>
<tr>
    <td>Kelas</td>
    <td>
        <input type="text" name="kelas">
    </td>
</tr>
<tr>
    <td>
        <button type="submit" value="Simpan">Simpan</button>
    </td>
</tr>
</table>
</form>
<hr>
<table border="1" cellpadding="10">
<tr>
    <th>NISN</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Aksi</th>
</tr>
<?php
$data = mysqli_query($conn,"SELECT * FROM input");
while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?php echo $d['nisn']; ?></td>
    <td><?php echo $d['nama']; ?></td>
    <td><?php echo $d['kelas']; ?></td>
    <td>
        <a href="edit.php?nisn=<?php echo $d['nisn']; ?>">Edit</a>
        <a href="delete.php?nisn=<?php echo $d['nisn']; ?>">Hapus</a>
    </td>
</tr>
<?php
}
?>
</table>
</body>
</html>