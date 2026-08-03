<?php
include "koneksi.php";
$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$sql = "UPDATE input SET
        nama='$nama',
        kelas='$kelas'
        WHERE nisn='$nisn'";
$query = mysqli_query($conn, $sql);
if($query){
    header("Location:index.php");
}else{
    echo "Data gagal diupdate!";
}
?>