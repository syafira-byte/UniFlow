<?php
session_start();
if(!isset($_SESSION['login'])){
    header('Location:../index.php');
    exit;
}

// === Koneksi Database ===
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jual";
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// === Pastikan kolom 'kelas' ada di tabel ===
$cek_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM data_penjualan LIKE 'kelas'");
if (mysqli_num_rows($cek_kolom) == 0) {
    mysqli_query($koneksi, "ALTER TABLE data_penjualan ADD COLUMN kelas VARCHAR(50) AFTER nama_pelanggan");
}

// === Simpan Data ===
if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $kelas = $_POST['kelas'];
    $nama_barang = $_POST['nama_barang'];
    $ukuran_barang = $_POST['ukuran_barang'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO data_penjualan (tanggal, nama_pelanggan, kelas, nama_barang, ukuran_barang, harga)
              VALUES ('$tanggal', '$nama_pelanggan', '$kelas', '$nama_barang', '$ukuran_barang', '$harga')";
    mysqli_query($koneksi, $query);
    echo "<script>alert('Data berhasil disimpan!');window.location='data_penjualan.php';</script>";
}

// === Update Data ===
if (isset($_POST['update'])) {
    $id = $_POST['id_pelanggan'];
    $tanggal = $_POST['tanggal'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $kelas = $_POST['kelas'];
    $nama_barang = $_POST['nama_barang'];
    $ukuran_barang = $_POST['ukuran_barang'];
    $harga = $_POST['harga'];

    $query = "UPDATE data_penjualan 
              SET tanggal='$tanggal',
                  nama_pelanggan='$nama_pelanggan',
                  kelas='$kelas',
                  nama_barang='$nama_barang',
                  ukuran_barang='$ukuran_barang',
                  harga='$harga'
              WHERE id_pelanggan='$id'";
    mysqli_query($koneksi, $query);
    echo "<script>alert('Data berhasil diupdate!');window.location='data_penjualan.php';</script>";
}

// === Hapus Data ===
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM data_penjualan WHERE id_pelanggan='$id'");
    echo "<script>alert('Data berhasil dihapus!');window.location='data_penjualan.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        body {
            background-color: #f5f7ff;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #1e40c5;
            color: white;
            text-align: center;
            padding: 18px;
            font-size: 22px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        /* Tombol Kembali */
        .back-btn {
            display: inline-block;
            margin: 20px 40px 0;
            background: #1e40c5;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
        }
        .back-btn:hover {
            background: #1532a2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            padding: 40px;
            flex-wrap: wrap;
        }
        .form-box {
            background: white;
            border-radius: 16px;
            padding: 25px;
            width: 380px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }
        .form-box h2 {
            color: #1e40c5;
            margin-bottom: 20px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            font-size: 16px;
            border: 1px solid #bbb;
            border-radius: 8px;
        }
        button {
            background: #1e40c5;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }
        button:hover { background: #1532a2; }
        a {
            text-decoration: none;
            color: #1e40c5;
            margin-left: 10px;
        }

        .table-container {
            flex: 1;
            min-width: 600px;
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }
        .table-container h2 {
            color: #1e40c5;
            margin-bottom: 15px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #1e40c5;
            color: white;
        }
        a.edit { color: #007bff; }
        a.hapus { color: #ff2e2e; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="navbar">🧾 Data Penjualan</div>

    <div class="container">
        <!-- Form Box -->
        <div class="form-box">
            <?php if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $data = mysqli_query($koneksi, "SELECT * FROM data_penjualan WHERE id_pelanggan='$id'");
                $d = mysqli_fetch_array($data);
            ?>
            <h2>Edit Data</h2>
            <form method="post">
                <input type="hidden" name="id_pelanggan" value="<?= $d['id_pelanggan']; ?>">
                <input type="date" name="tanggal" value="<?= $d['tanggal']; ?>" required>
                <label>Nama Pelanggan</label>
                <select name="nama_pelanggan" required>
                    <option value="">-Pilih Pelanggan-</option>
                    <?php
                    $pelanggan = [
                        "MOHAMAD QOIS AL QORNI","MOHAMMAD ALFINO ROSI","MOHAMMAD IKBAL","MOH. REZA FIRMANSYAH",
                        "MUHAMAD ANGGA HIDAYATULLAH","MUHAMMAD ADLY FAIRUS","MUHAMMAD ALIEF ALFARIZI","MUHAMMAD DAYU",
                        "MUHAMMAD DZAKI RAFIUDDIN","MUHAMMAD FAHRI PUTRA","MUHAMMAD FAREL AFANDI","MUHAMMAD IRSYADUL IBAD",
                        "MUHAMMAD REFFAN","NADIFA AINIA","NAHASON FEBRIAN GIBAN","NAILATUL HASANAH","NASIHUL WILDAN",
                        "NICOLAS AIDIL KURNIAWANSYAH","NOVELIA NUR ROHMAH","NUR FADHILA","PASA WANDI SAPUTRA","PRAWIRA",
                        "QONITA ARIBA","RADITYA ANANDA","RICKY JORDAN","RIIHADATUL AISYAH ALHANA","RISKIYA",
                        "SANTI TIARA AMELIA","SELFYTA DIANA PUTRI","SILVIANA PRAPSARI WAHYUNITA","SYAFIRA WAHYU NENGTRIYAS",
                        "SYAHRUL HIDAYAH","TRI SHINTA WULANDARI","ULIL RAMADANI","YOGHA PRATAMA"
                    ];
                    foreach ($pelanggan as $p) {
                        $selected = ($d['nama_pelanggan'] == $p) ? 'selected' : '';
                        echo "<option $selected>$p</option>";
                    }
                    ?>
                </select>

                <label>Kelas</label>
                <input type="text" name="kelas" value="<?= $d['kelas']; ?>" required>

                <label>Nama Barang</label>
                <select name="nama_barang" required>
                    <?php
                    $barang = [
                        "Seragam Abu Putih (L)","Seragam Abu Putih (P)","Seragam Jurusan (L)","Seragam Jurusan (P)",
                        "Baju Batik (L)","Baju Batik (P)","Kedisplinan (L)","Kedisplinan (P)",
                        "Seragam Olahraga (L)","Seragam Olahraga (P)","Seragam Pramuka (L)","Seragam Pramuka (P)","Jas"
                    ];
                    foreach ($barang as $b) {
                        $selected = ($d['nama_barang'] == $b) ? 'selected' : '';
                        echo "<option $selected>$b</option>";
                    }
                    ?>
                </select>

                <label>Ukuran Barang</label>
                <select name="ukuran_barang" required>
                    <?php
                    foreach (["S","M","L","XL"] as $u) {
                        $selected = ($d['ukuran_barang'] == $u) ? 'selected' : '';
                        echo "<option $selected>$u</option>";
                    }
                    ?>
                </select>

                <input type="number" name="harga" value="<?= $d['harga']; ?>" placeholder="Harga" required>
                <button type="submit" name="update">Update</button>
                <a href="data_penjualan.php">Batal</a>
            </form>

            <?php } else { ?>
            <h2>Tambah Data</h2>
            <form method="post">
                <input type="date" name="tanggal" required>
                <label>Nama Pelanggan</label>
                <select name="nama_pelanggan" required>
                    <option value="">-Pilih Pelanggan-</option>
                    <option>MOHAMAD QOIS AL QORNI</option>
                    <option>MOHAMMAD ALFINO ROSI</option>
                    <option>MOHAMMAD IKBAL</option>
                    <option>MOH. REZA FIRMANSYAH</option>
                    <option>MUHAMAD ANGGA HIDAYATULLAH</option>
                    <option>MUHAMMAD ADLY FAIRUS</option>
                    <option>MUHAMMAD ALIEF ALFARIZI</option>
                    <option>MUHAMMAD DAYU</option>
                    <option>MUHAMMAD DZAKI RAFIUDDvIN
                    <option>MUHAMMAD FAHRI PUTRA</option>
                    <option>MUHAMMAD FAREL AFANDI</option>
                    <option>MUHAMMAD IRSYADUL IBAD</option>
                    <option>MUHAMMAD REFFAN</option>
                    <option>NADIFA AINIA</option>
                    <option>NAHASON FEBRIAN GIBAN</option>
                    <option>NAILATUL HASANAH</option>
                    <option>NASIHUL WILDAN</option>
                    <option>NICOLAS AIDIL KURNIAWANSYA</option>
                    <option>NOVELIA NUR ROHMAH</option>
                    <option>NUR FADHILA</option>
                    <option>PASA WANDI SAPUTRA</option>
                    <option>PRAWIRA</option>
                    <option>QONITA ARIBA</option>
                    <option>RADITYA ANANDA</option>
                    <option>RICKY JORDAN</option>
                    <option>RIIHADATUL AISYAH ALHANA</option>
                    <option>RISKIYA</option>
                    <option>SANTI TIARA AMELIA</option>
                    <option>SELFYTA DIANA PUTRI</option>
                    <option>SILVIANA PRAPSARI WAHYUNITA</option>
                    <option>SYAFIRA WAHYU NENGTRIYAS</option>
                    <option>SYAHRUL HIDAYAH</option>
                    <option>TRI SHINTA WULANDARI</option>
                    <option>ULIL RAMADANI</option>
                    <option>YOGHA PRATAMA</option>

                    <?php foreach ($pelanggan as $p) echo "<option>$p</option>"; ?>
                </select>

                <label>Kelas</label>
                <input type="text" name="kelas" placeholder="Contoh: XI RPL 3" required>

                <label>Nama Barang</label>
                <select name="nama_barang" required>
                    <option value="">-Pilih Barang-</option>
                        <option>Seragam Abu Putih (L)</option>
                        <option>Seragam Abu Putih (P)</option>
                        <option>Seragam Jurusan (L)</option>
                        <option>Seragam Jurusan (P)</option>
                        <option>Baju Batik (L)</option>
                        <option>Baju Batik (P)</option>
                        <option>Kedisplinan (L)</option>
                        <option>Kedisplinan (P)</option>
                        <option>Seragam Olahraga (L)</option>
                        <option>Seragam Olahraga (P)</option>
                        <option>Seragam Pramuka (L)</option>
                        <option>Seragam Pramuka (P)</option>
                        <option>Jas</option>
                    <?php foreach ($barang as $b) echo "<option>$b</option>"; ?>
                </select>

                <label>Ukuran Barang</label>
                <select name="ukuran_barang" required>
                    <option value="">-Pilih Ukuran-</option>
                    <option>S</option><option>M</option><option>L</option><option>XL</option>
                </select>

                <input type="number" name="harga" placeholder="Harga" required>
                <button type="submit" name="simpan">Simpan</button>
            </form>
            <?php } ?>
        </div>

        <!-- Table -->
        <div class="table-container">
            <h2>📋 Daftar Data Penjualan</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Kelas</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM data_penjualan ORDER BY id_pelanggan DESC");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['tanggal']; ?></td>
                    <td><?= $d['nama_pelanggan']; ?></td>
                    <td><?= $d['kelas']; ?></td>
                    <td><?= $d['nama_barang']; ?></td>
                    <td><?= $d['ukuran_barang']; ?></td>
                    <td>Rp<?= number_format($d['harga']); ?></td>
                    <td>
                        <a class="edit" href="data_penjualan.php?edit=<?= $d['id_pelanggan']; ?>">Edit</a> |
                        <a class="hapus" href="data_penjualan.php?hapus=<?= $d['id_pelanggan']; ?>" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
