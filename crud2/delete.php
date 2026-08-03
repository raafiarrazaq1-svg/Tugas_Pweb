<?php
include "koneksi.php";
$nisn = $_GET['nisn'];
$sql = "DELETE FROM input WHERE nisn='$nisn'";
$query = mysqli_query($conn, $sql);
if($query){
    header("Location:index.php");
}else{
    echo "Data gagal dihapus!";
}
?>