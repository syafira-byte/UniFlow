<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UniFlow - Welcome</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
  <!-- Custom styles -->
  <style>
    .hero-section {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 100px 0;
      text-align: center;
    }
    .hero-section h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
    }
    .hero-section p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
    }
    .features-section {
      padding: 80px 0;
      background-color: #f8f9fa;
    }
    .feature-card {
      text-align: center;
      margin-bottom: 2rem;
    }
    .feature-icon {
      font-size: 3rem;
      color: #007bff;
      margin-bottom: 1rem;
    }
    .cta-section {
      padding: 80px 0;
      text-align: center;
    }
    .btn-lg-custom {
      padding: 1rem 2rem;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #007bff;">
    <div class="container">
      <a class="navbar-brand" href="#"><b>Uni</b>Flow</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#features">Fitur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Mulai</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1>Selamat Datang <b>Uni</b>Flow</h1>
      <p class="lead">Sederhana alur kerja Anda dan tingkatkan produktivitas dengan platform manajemen kami.</p>
      <a href="login.php" class="btn btn-light btn-lg-custom">MULAI</a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section" id="features">
    <div class="container">
      <h2 class="text-center mb-5">Mengapa Memilih UniFlow?</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="feature-card">
            <i class="fas fa-chart-line feature-icon"></i>
            <h4>Analisis Data</h4>
            <p>Dapatkan wawasan tentang data penjualan dan inventasris Anda dengan alat analitik yang canggih.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <i class="fas fa-tasks feature-icon"></i>
            <h4>Manajemen Tugas</h4>
            <p>Atur dan lacak Anda secara efisien dengan papan kami.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <i class="fas fa-users feature-icon"></i>
            <h4>Kolaborasi Tim</h4>
            <p>Bekerja secara lancar dengan tim Anda memulai pembaruan waktu nyata dan ruang kerja bersama.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="cta-section">
    <div class="container">
      <h2>Siap untuk terorganisir?</h2>
      <p class="lead">Bergabung dengan ribuan pengguna yang mempercayai UniFlow untuk kebutuhan manajemen alur kerja mereka.</p>
      <a href="login.php" class="btn btn-primary btn-lg-custom">Mulai Sekarang</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2025 UniFlow. Semua Hak Cipta Dilindungu.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="app/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="app/dist/js/adminlte.min.js"></script>
</body>
</html>
