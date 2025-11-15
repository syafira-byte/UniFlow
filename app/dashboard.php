<?php
include '../conf/config.php';

// Ambil data ringkasan
$total_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM rekapan_penjualan"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total_harga) AS total FROM rekapan_penjualan"))['total'];
$jenis_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT nama_barang) AS total FROM rekapan_penjualan"))['total'];

// Data tabel
$data_penjualan = mysqli_query($koneksi, "SELECT * FROM rekapan_penjualan ORDER BY tanggal_penjualan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sultan - Penjualan Seragam Sekolah</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ebeef1 0%, #fff 30%, #f0f2f4 70%, #f1f2f5 100%);
            margin: 0;
            padding: 0;
            color: #1f2937;
            overflow-x: hidden;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(90deg, #1e3a8a, #2563eb, #60a5fa);
            color: white;
            padding: 25px 40px;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 25px rgba(30,64,175,0.4);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .container {
            padding: 50px 70px;
            max-width: 1300px;
            margin: auto;
        }
        .card-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            background: rgba(251, 247, 247, 0.85);
            flex: 1;
            min-width: 280px;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        .icon {
            font-size: 42px;
            margin-bottom: 10px;
        }
        .card h3 {
            color: #1e3a8a;
            font-weight: 600;
            margin: 0;
        }
        .card p {
            font-size: 30px;
            font-weight: bold;
            color: #111827;
            margin-top: 10px;
        }
        .section { margin-top: 60px; }
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .title::before {
            content: "📘";
            margin-right: 10px;
            font-size: 26px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.9);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }
        th {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            color: white;
            padding: 14px;
            text-transform: uppercase;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #cad3e4;
            color: #374151;
        }
        tr:hover td {
            background: #e0e7ff;
        }
        .status-lunas {
            color: #16a34a;
            font-weight: bold;
        }
        .status-belum {
            color: #dc2626;
            font-weight: bold;
        }
        .desc {
            margin-top: 30px;
            background: rgba(219,234,254,0.8);
            padding: 20px 25px;
            border-left: 6px solid #2563eb;
            border-radius: 12px;
            color: #1f2937;
            font-size: 16px;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <header>Penjualan Seragam Sekolah 👔</header>

    <div class="container">
        <div class="card-container">
            <div class="card">
                <div class="icon">📦</div>
                <h3>Total Transaksi</h3>
                <p><?= $total_transaksi; ?></p>
            </div>
            <div class="card">
                <div class="icon">💎</div>
                <h3>Total Pendapatan</h3>
                <p>Rp<?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
            <div class="card">
                <div class="icon">🧥</div>
                <h3>Jenis Barang Terjual</h3>
                <p><?= $jenis_barang; ?></p>
            </div>
        </div>

        <div class="section">
            <div class="title">Data Rekapan Penjualan Seragam</div>

            <table>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Kelas</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Keterangan</th>
                </tr>
                <?php
                $no = 1;
                while ($d = mysqli_fetch_assoc($data_penjualan)) {
                    $status = strtolower($d['keterangan']);
                    if ($status === 'lunas') {
                        $status_text = "<span class='status-lunas'>Lunas</span>";
                        $keterangan = "Sudah Lunas";
                    } else {
                        $status_text = "<span class='status-belum'>Belum Lunas</span>";
                        $kekurangan = $d['total_harga'] - $d['pembayaran'];
                        $keterangan = "Kekurangan Rp" . number_format($kekurangan, 0, ',', '.');
                    }

                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$d['tanggal_penjualan']}</td>
                            <td>{$d['nama_pelanggan']}</td>
                            <td>{$d['kelas']}</td>
                            <td>{$d['nama_barang']}</td>
                            <td>{$d['ukuran']}</td>
                            <td>Rp" . number_format($d['total_harga'], 0, ',', '.') . "</td>
                            <td>{$status_text}</td>
                            <td>{$keterangan}</td>
                          </tr>";
                    $no++;
                }
                ?>
            </table>

            <div class="desc">
                Penjelasan Fitur<br>
                Bagian ini menampilkan seluruh transaksi penjualan seragam sekolah beserta status pembayarannya. 
                Setiap transaksi akan ditandai dengan warna sebagai indikator status pembayaran:<br>
                🟢 Warna hijau menandakan pembayaran sudah lunas<br>
                🔴 Warna merah berarti pembayaran belum lunas dan akan menampilkan nominal kekurangan pembayaran<br>
                Fitur ini memudahkan pihak sekolah untuk melakukan pemantauan transaksi secara cepat, akurat, dan terstruktur.<br><br><br>

                Tunggu apa lagi?<br>
                Mari beralih ke sistem yang lebih modern dan profesional!<br>
                🚀 Gunakan sekarang dan rasakan kemudahannya!<br>
                👉 Mulai Atur Pembayaran Seragam dengan Lebih Praktis<br>
            </div>
        </div>
    </div>
</body>
</html>
