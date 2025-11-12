<?php
include '../conf/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM stok_barang WHERE id_barang='$id'");
    echo "<script>alert('Data stok berhasil dihapus!');window.location='stok_barang.php';</script>";
} else {
    echo "<script>alert('ID tidak ditemukan!');window.location='stok_barang.php';</script>";
}
?>
