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
            background: linear-gradient(135deg, #ebeef1ff 0%, #ffffffff 30%, #f0f2f4ff 70%, #f1f2f5ff 100%);
            margin: 0;
            padding: 0;
            color: #1f2937;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Efek bokeh background lembut */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.3), transparent 60%),
                        radial-gradient(circle at 80% 80%, rgba(173,216,230,0.2), transparent 60%);
            z-index: -1;
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
            backdrop-filter: blur(15px);
            text-shadow: 0 0 10px rgba(255,255,255,0.5);
            animation: fadeInDown 1s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            padding: 50px 70px;
            max-width: 1300px;
            margin: auto;
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.5);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .card::after {
            content: '';
            position: absolute;
            top: -60%;
            left: -60%;
            width: 220%;
            height: 220%;
            background: conic-gradient(from 180deg, rgba(96,165,250,0.3), rgba(255,255,255,0), rgba(59,130,246,0.3));
            transform: rotate(45deg);
            transition: all 0.8s ease;
        }

        .card:hover::after {
            transform: rotate(225deg);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 50px rgba(59,130,246,0.25);
        }

        .icon {
            font-size: 42px;
            margin-bottom: 10px;
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
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
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .section {
            margin-top: 60px;
        }

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
            backdrop-filter: blur(10px);
            animation: fadeIn 1.5s ease;
        }

        table th {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            color: white;
            padding: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #cad3e4ff;
            color: #374151;
            font-weight: 500;
        }

        table tr:hover td {
            background: #e0e7ff;
            transition: 0.3s;
        }

        .desc {
            margin-top: 30px;
            background: rgba(219,234,254,0.8);
            padding: 20px 25px;
            border-left: 6px solid #2563eb;
            border-radius: 12px;
            color: #1f2937;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            font-size: 16px;
            line-height: 1.8;
            animation: fadeInUp 1.2s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            margin-top: 60px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            padding: 20px;
        }

        footer span {
            color: #1e3a8a;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>
        Penjualan Seragam Sekolah 👔
    </header>

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
                </tr>
                <?php
                $no = 1;
                while ($d = mysqli_fetch_assoc($data_penjualan)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$d['tanggal_penjualan']}</td>
                            <td>{$d['nama_pelanggan']}</td>
                            <td>{$d['kelas']}</td>
                            <td>{$d['nama_barang']}</td>
                            <td>{$d['ukuran']}</td>
                            <td>Rp" . number_format($d['total_harga'], 0, ',', '.') . "</td>
                          </tr>";
                    $no++;
                }
                ?>
            </table>

            <div class="desc">
                Bagian ini menampilkan seluruh transaksi penjualan seragam sekolah dengan tampilan mewah dan modern.  
                Didesain dengan konsep glass morphism dan gradasi lembut agar setiap data mudah dibaca, namun tetap elegan seperti dashboard profesional.
            </div>
        </div>

    </div>
</body>
</html>
