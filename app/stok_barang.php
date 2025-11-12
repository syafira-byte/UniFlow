<?php
include '../conf/config.php';

// Tambah data
if (isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Simpan ke database
    $query = mysqli_query($koneksi, "INSERT INTO stok_barang (nama_barang, harga, stok) VALUES ('$nama_barang', '$harga', '$stok')");

    if ($query) {
        echo "<script>alert('Data berhasil disimpan!');window.location='stok_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Stok Barang</title>
</head>
<body>
    <div class="navbar">📦 Data Stok Barang</div>

    <!-- Tombol Kembali ke Dashboard -->
<a href="index.php" class="back-btn">⬅️ Kembali ke Dashboard</a>

<style>
.back-btn {
    display: inline-block;
    background-color: #1e40c5; /* warna biru sama seperti tabel */
    color: white;               /* tulisan putih */
    padding: 10px 20px;         /* jarak dalam tombol */
    margin: 20px 0;             /* jarak atas-bawah */
    border-radius: 6px;         /* sudut membulat */
    text-decoration: none;      /* hapus garis bawah */
    font-weight: 500;           /* tulisan agak tebal */
}

.back-btn:hover {
    background-color: #1532a2;  /* warna biru lebih gelap saat hover */
}
</style>


    <div class="container">
        <!-- Form tambah -->
        <div class="form-box">
            <h2>Tambah Data Stok</h2>
            <form method="post">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Masukkan nama barang" required>

                <label>Harga</label>
                <input type="number" name="harga" placeholder="Masukkan harga" required>

                <label>Stok</label>
                <input type="number" name="stok" placeholder="Masukkan jumlah stok" required>

                <button type="submit" name="simpan">Simpan</button>
            </form>
        </div>

        <!-- Tabel data -->
        <div style="flex:1;">
            <h2>📋 Daftar Stok Barang</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
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
                    <td>
                        <a href="hapus_stok.php?id=<?= $d['id_barang']; ?>" class="hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background: linear-gradient(135deg, #e0e7ff, #f3f4f6);
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    .navbar {
        width: 100%;
        background: linear-gradient(90deg, #1e3a8a, #2563eb);
        color: white;
        text-align: center;
        padding: 18px;
        font-size: 24px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 30px;
        margin-top: 50px;
        width: 95%;
        flex-wrap: wrap;
    }

    .form-box {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        padding: 25px;
        width: 350px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .form-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    h2 {
        color: #1e3a8a;
        margin-bottom: 20px;
        text-align: center;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #f9fafb;
        font-size: 15px;
        transition: 0.2s;
    }

    input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 4px #2563eb80;
        outline: none;
    }

    button {
        background: #2563eb;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    button:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }

    table {
        flex: 1;
        border-collapse: collapse;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        min-width: 100%;
        transition: 0.3s;
    }

    table:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    th, td {
        border: 1px solid #e5e7eb;
        padding: 14px 10px;
        text-align: center;
        font-size: 15px;
    }

    th {
        background: linear-gradient(90deg, #1e3a8a, #2563eb);
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tr:nth-child(even) {
        background-color: #f9fafb;
    }

    tr:hover {
        background-color: #e0e7ff;
        transition: 0.2s;
    }

    a.hapus {
        color: #dc2626;
        text-decoration: none;
        font-weight: 600;
    }

    a.hapus:hover {
        text-decoration: underline;
    }

    h2 + table {
        margin-top: 10px;
    }
</style>
</body>
</html>
