<?php
$koneksi = mysqli_connect("localhost", "root", "", "jual");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tambah data
if (isset($_POST['tambah'])) {
    $tanggal_penjualan = $_POST['tanggal_penjualan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $kelas = $_POST['kelas'];
    $nama_barang = $_POST['nama_barang'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];
    $total_harga = $jumlah * $harga_satuan;
    $total = $_POST['total'];
    $pembayaran = $_POST['pembayaran'];
    $keterangan = ($pembayaran >= $total) ? "Lunas" : "Belum Lunas";

    mysqli_query($koneksi, "INSERT INTO rekapan_penjualan 
        (tanggal_penjualan, nama_pelanggan, kelas, nama_barang, ukuran, jumlah, harga_satuan, total_harga, total, pembayaran, keterangan)
        VALUES 
        ('$tanggal_penjualan', '$nama_pelanggan', '$kelas', '$nama_barang', '$ukuran', '$jumlah', '$harga_satuan', '$total_harga', '$total', '$pembayaran', '$keterangan')");
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM rekapan_penjualan WHERE id_rekapan='$id'");
    header("Location: rekapan_penjualan.php");
    exit;
}

// Update data
if (isset($_POST['update'])) {
    $id_rekapan = $_POST['id_rekapan'];
    $tanggal_penjualan = $_POST['tanggal_penjualan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $kelas = $_POST['kelas'];
    $nama_barang = $_POST['nama_barang'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];
    $total_harga = $jumlah * $harga_satuan;
    $total = $_POST['total'];
    $pembayaran = $_POST['pembayaran'];
    $keterangan = ($pembayaran >= $total) ? "Lunas" : "Belum Lunas";

    mysqli_query($koneksi, "UPDATE rekapan_penjualan SET 
        tanggal_penjualan='$tanggal_penjualan',
        nama_pelanggan='$nama_pelanggan',
        kelas='$kelas',
        nama_barang='$nama_barang',
        ukuran='$ukuran',
        jumlah='$jumlah',
        harga_satuan='$harga_satuan',
        total_harga='$total_harga',
        total='$total',
        pembayaran='$pembayaran',
        keterangan='$keterangan'
        WHERE id_rekapan='$id_rekapan'");
    header("Location: rekapan_penjualan.php");
    exit;
}

// daftar seragam dan nama pelanggan
$namaBarang = [
    "Seragam Abu Putih (L)", "Seragam Abu Putih (P)",
    "Seragam Jurusan (L)", "Seragam Jurusan (P)",
    "Baju Batik (L)", "Baju Batik (P)",
    "Kedisplinan (L)", "Kedisplinan (P)",
    "Seragam Olahraga (L)", "Seragam Olahraga (P)",
    "Seragam Pramuka (L)", "Seragam Pramuka (P)",
    "Jas"
];

$ukuran = ["S", "M", "L", "XL"];

$namaPelanggan = [
"MOHAMAD QOIS AL QORNI","MOHAMMAD ALFINO ROSI","MOHAMMAD IKBAL",
"MOH. REZA FIRMANSYAH","MUHAMAD ANGGA HIDAYATULLAH","MUHAMMAD ADLY FAIRUS",
"MUHAMMAD ALIEF ALFARIZI","MUHAMMAD DAYU","MUHAMMAD DZAKI RAFIUDDIN",
"MUHAMMAD FAHRI PUTRA","MUHAMMAD FAREL AFANDI","MUHAMMAD IRSYADUL IBAD",
"MUHAMMAD REFFAN","NADIFA AINIA","NAHASON FEBRIAN GIBAN","NAILATUL HASANAH",
"NASIHUL WILDAN","NICOLAS AIDIL KURNIAWANSYAH","NOVELIA NUR ROHMAH",
"NUR FADHILA","PASA WANDI SAPUTRA","PRAWIRA","QONITA ARIBA","RADITYA ANANDA",
"RICKY JORDAN","RIIHADATUL AISYAH ALHANA","RISKIYA","SANTI TIARA AMELIA",
"SELFYTA DIANA PUTRI","SILVIANA PRAPSARI WAHYUNITA","SYAFIRA WAHYU NENGTRIYAS",
"SYAHRUL HIDAYAH","TRI SHINTA WULANDARI","ULIL RAMADANI"
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekapan Penjualan Seragam</title>
</head>
<body>

<h2>📋 Rekapan Penjualan Seragam</h2>

<div class="form-box">
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = mysqli_query($koneksi, "SELECT * FROM rekapan_penjualan WHERE id_rekapan='$id'");
    $row = mysqli_fetch_assoc($editData);
?>
    <h3>Edit Data</h3>
    <form method="POST">
        <input type="hidden" name="id_rekapan" value="<?= $row['id_rekapan']; ?>">
        <input type="date" name="tanggal_penjualan" value="<?= $row['tanggal_penjualan']; ?>" required><br>

        <label>Nama Pelanggan</label><br>
        <select name="nama_pelanggan" required>
            <option>-Pilih Nama Pelanggan-</option>
            <?php foreach ($namaPelanggan as $n): ?>
                <option value="<?= $n ?>" <?= ($row['nama_pelanggan']==$n?'selected':'') ?>><?= $n ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="text" name="kelas" value="<?= $row['kelas']; ?>" placeholder="Kelas" required><br>

        <label>Nama Barang</label><br>
        <select name="nama_barang" required>
            <option>-Pilih Seragam-</option>
            <?php foreach ($namaBarang as $b): ?>
                <option value="<?= $b ?>" <?= ($row['nama_barang']==$b?'selected':'') ?>><?= $b ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Ukuran</label><br>
        <select name="ukuran" required>
            <option>-Pilih Ukuran-</option>
            <?php foreach ($ukuran as $u): ?>
                <option value="<?= $u ?>" <?= ($row['ukuran']==$u?'selected':'') ?>><?= $u ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="number" name="jumlah" value="<?= $row['jumlah']; ?>" placeholder="Jumlah" required><br>
        <input type="number" name="harga_satuan" value="<?= $row['harga_satuan']; ?>" placeholder="Harga Satuan" required><br>
        <input type="number" name="total" value="<?= $row['total']; ?>" placeholder="Total" required><br>
        <input type="number" name="pembayaran" value="<?= $row['pembayaran']; ?>" placeholder="Pembayaran" required><br>

        <button type="submit" name="update">Update</button>
        <a href="rekapan_penjualan.php">Batal</a>
    </form>

<?php } else { ?>
    <h3>Tambah Data Baru</h3>
    <form method="POST">
        <input type="date" name="tanggal_penjualan" required><br>

        <label>Nama Pelanggan</label><br>
        <select name="nama_pelanggan" required>
            <option>-Pilih Nama Pelanggan-</option>
            <?php foreach ($namaPelanggan as $n): ?>
                <option><?= $n ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="text" name="kelas" placeholder="Kelas" required><br>

        <label>Nama Barang</label><br>
        <select name="nama_barang" required>
            <option>-Pilih Seragam-</option>
            <?php foreach ($namaBarang as $b): ?>
                <option><?= $b ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Ukuran</label><br>
        <select name="ukuran" required>
            <option>-Pilih Ukuran-</option>
            <?php foreach ($ukuran as $u): ?>
                <option><?= $u ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="number" name="jumlah" placeholder="Jumlah" required><br>
        <input type="number" name="harga_satuan" placeholder="Harga Satuan" required><br>
        <input type="number" name="total" placeholder="Total Harga" required><br>
        <input type="number" name="pembayaran" placeholder="Pembayaran" required><br>

        <button type="submit" name="tambah">Tambah</button>
    </form>
<?php } ?>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Nama Pelanggan</th>
        <th>Kelas</th>
        <th>Nama Barang</th>
        <th>Ukuran</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total Harga</th>
        <th>Total</th>
        <th>Pembayaran</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($koneksi, "SELECT * FROM rekapan_penjualan ORDER BY id_rekapan DESC");
    while ($d = mysqli_fetch_array($data)) {
        $warna = ($d['keterangan'] == "Lunas") ? "lunas" : "belum-lunas";
        echo "<tr>
            <td>{$d['id_rekapan']}</td>
            <td>{$d['tanggal_penjualan']}</td>
            <td>{$d['nama_pelanggan']}</td>
            <td>{$d['kelas']}</td>
            <td>{$d['nama_barang']}</td>
            <td>{$d['ukuran']}</td>
            <td>{$d['jumlah']}</td>
            <td>Rp " . number_format($d['harga_satuan'], 0, ',', '.') . "</td>
            <td>Rp " . number_format($d['total_harga'], 0, ',', '.') . "</td>
            <td>Rp " . number_format($d['total'], 0, ',', '.') . "</td>
            <td>Rp " . number_format($d['pembayaran'], 0, ',', '.') . "</td>
            <td class='$warna'>{$d['keterangan']}</td>
            <td>
                <a href='?edit={$d['id_rekapan']}'>Edit</a> | 
                <a href='?hapus={$d['id_rekapan']}' onclick='return confirm(\"Yakin hapus data?\")'>Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e0e7ff, #f3f4f6);
        margin: 0;
        padding: 0;
        text-align: center;
    }

    h2 {
        background: #1e3a8a;
        color: white;
        padding: 20px 0;
        margin: 0;
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        letter-spacing: 1px;
    }

    .form-box {
        background: white;
        padding: 25px;
        border-radius: 15px;
        width: 90%;
        max-width: 1100px;
        margin: 40px auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        transition: 0.3s;
    }

    .form-box:hover {
        transform: scale(1.01);
    }

    input, select {
        width: 95%;
        padding: 10px;
        margin: 6px 0;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background-color: #f9fafb;
        font-size: 14px;
        transition: 0.2s;
    }

    input:focus, select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 4px #2563eb80;
        outline: none;
    }

    button {
        background: #2563eb;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        margin-top: 10px;
        transition: 0.3s;
    }

    button:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 40px auto;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 12px 10px;
        border: 1px solid #e5e7eb;
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

    .lunas {
        color: #16a34a;
        font-weight: bold;
    }

    .belum-lunas {
        color: #dc2626;
        font-weight: bold;
    }

    a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
</body>
</html>
