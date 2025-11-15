<?php
include '../conf/config.php';

// MODE EDIT
$editMode = false;
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $q = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE id_barang='$id'");
    $editData = mysqli_fetch_assoc($q);
    if ($editData) {
        $editMode = true;
    }
}

// SIMPAN DATA BARU
if (isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $stok_ukuran_s = $_POST['stok_ukuran_s'];
    $stok_ukuran_m = $_POST['stok_ukuran_m'];
    $stok_ukuran_l = $_POST['stok_ukuran_l'];
    $stok_ukuran_xl = $_POST['stok_ukuran_xl'];

    mysqli_query($koneksi, 
        "INSERT INTO stok_barang (nama_barang, harga, stok, stok_ukuran_s, stok_ukuran_m, stok_ukuran_l, stok_ukuran_xl)
        VALUES ('$nama_barang','$harga','$stok','$stok_ukuran_s','$stok_ukuran_m','$stok_ukuran_l','$stok_ukuran_xl')"
    );

    echo "<script>alert('Data berhasil disimpan!');window.location='stok_barang.php';</script>";
}

// UPDATE DATA (EDIT)
if (isset($_POST['update'])) {

    mysqli_query($koneksi,
        "UPDATE stok_barang SET 
            nama_barang='$_POST[nama_barang]',
            harga='$_POST[harga]',
            stok='$_POST[stok]',
            stok_ukuran_s='$_POST[stok_ukuran_s]',
            stok_ukuran_m='$_POST[stok_ukuran_m]',
            stok_ukuran_l='$_POST[stok_ukuran_l]',
            stok_ukuran_xl='$_POST[stok_ukuran_xl]'
        WHERE id_barang='$_POST[id_barang]'"
    );

    echo "<script>alert('Data berhasil diupdate!');window.location='stok_barang.php';</script>";
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM stok_barang WHERE id_barang='$_GET[hapus]'");
    echo "<script>alert('Data berhasil dihapus!');window.location='stok_barang.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Stok Barang</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    margin: 0;
    padding: 0;
}

.navbar {
    background: #1e40c5;
    color: #fff;
    padding: 15px;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
}

.container {
    width: 90%;
    margin: auto;
    padding-top: 20px;
}

/* Tombol Kembali */
.back-btn {
    display: inline-block;
    background-color: #1e40c5;
    color: white;
    padding: 10px 20px;
    margin: 15px 0;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
}
.back-btn:hover {
    background-color: #1532a2;
}

/* BOX FORM */
.form-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 0 7px rgba(0,0,0,0.15);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.form-box h2 {
    margin-bottom: 15px;
    text-align: center;
}

form label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

form input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form button {
    margin-top: 15px;
    background: #1e40c5;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
}
form button:hover {
    background: #1532a2;
}

/* Tabel fix tidak melebar */
table {
    width: auto;
    max-width: 1100px;
    margin: auto;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 0 7px rgba(0,0,0,0.15);
    border: 1px solid #ccc;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

th {
    background: #1e40c5;
    color: white;
    white-space: nowrap;
}

/* Kolom ukuran kecil */
th.size, td.size {
    width: 40px;
    max-width: 40px;
    text-align: center;
    white-space: nowrap;
}

/* Aksi */
.aksi a {
    margin: 0 5px;
    text-decoration: none;
    font-weight: bold;
}

.edit {
    color: #1e90ff;
}

.hapus {
    color: red;
}
</style>

</head>
<body>

<div class="navbar">📦 Data Stok Barang</div>

<a href="index.php" class="back-btn">⬅️ Kembali ke Dashboard</a>

<div class="container">

    <!-- FORM DI ATAS -->
    <div class="form-box">
        <h2><?= $editMode ? "Edit Data Stok" : "Tambah Data Stok" ?></h2>

        <form method="post">

            <?php if ($editMode) { ?>
                <input type="hidden" name="id_barang" value="<?= $editData['id_barang']; ?>">
            <?php } ?>

            <label>Nama Barang</label>
            <input type="text" name="nama_barang" required value="<?= $editMode ? $editData['nama_barang'] : '' ?>">

            <label>Harga</label>
            <input type="number" name="harga" required value="<?= $editMode ? $editData['harga'] : '' ?>">

            <label>Stok Total</label>
            <input type="number" name="stok" required value="<?= $editMode ? $editData['stok'] : '' ?>">

            <label>Stok Ukuran S</label>
            <input type="number" name="stok_ukuran_s" required value="<?= $editMode ? $editData['stok_ukuran_s'] : '' ?>">

            <label>Stok Ukuran M</label>
            <input type="number" name="stok_ukuran_m" required value="<?= $editMode ? $editData['stok_ukuran_m'] : '' ?>">

            <label>Stok Ukuran L</label>
            <input type="number" name="stok_ukuran_l" required value="<?= $editMode ? $editData['stok_ukuran_l'] : '' ?>">

            <label>Stok Ukuran XL</label>
            <input type="number" name="stok_ukuran_xl" required value="<?= $editMode ? $editData['stok_ukuran_xl'] : '' ?>">

            <button type="submit" name="<?= $editMode ? 'update' : 'simpan' ?>">
                <?= $editMode ? 'Update Data' : 'Simpan' ?>
            </button>

        </form>
    </div>

    <!-- DATA TABEL -->
    <h2 style="text-align:center;">📋 Daftar Stok Barang</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok Total</th>
            <th class="size">S</th>
            <th class="size">M</th>
            <th class="size">L</th>
            <th class="size">XL</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM stok_barang ORDER BY id_barang DESC");
        while ($d = mysqli_fetch_array($data)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['nama_barang']); ?></td>
            <td>Rp<?= number_format($d['harga']); ?></td>
            <td><?= $d['stok']; ?></td>
            <td class="size"><?= $d['stok_ukuran_s']; ?></td>
            <td class="size"><?= $d['stok_ukuran_m']; ?></td>
            <td class="size"><?= $d['stok_ukuran_l']; ?></td>
            <td class="size"><?= $d['stok_ukuran_xl']; ?></td>
            <td class="aksi">
                <a class="edit" href="stok_barang.php?edit=<?= $d['id_barang']; ?>">Edit</a> |
                <a class="hapus" href="stok_barang.php?hapus=<?= $d['id_barang']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>
