<?php
$koneksi = mysqli_connect('localhost','root','','jual');

if(!$koneksi){
  die("Koneksi Gagal:". mysqli_connect_error());
}
?>
