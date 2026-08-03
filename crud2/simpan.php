<?php
include "koneksi.php";
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$sql = "INSERT INTO input(nisn,nama,kelas)
        VALUES('$nisn','$nama','$kelas')";
$query = mysqli_query($conn,$sql);
if($query){
    header("Location:index.php");
}else{
    echo "Data gagal disimpan!";
}
?>