<?php
$host = "localhost";
$user = "root";
$pw = "";
$db = "crud2";

$conn = mysqli_connect($host,$user,$pw,$db);

if(!$conn){
    die("koneksi error : ".mysqli_connect_error());
}
?>