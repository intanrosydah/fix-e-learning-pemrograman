<?php
require 'header-login.php'; // Memasukkan header
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Penukaran Api</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />

  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
    rel="stylesheet" />

  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
      color: white;
    }

    .navbar {
      padding: 0;
      position: fixed;
      top: 0;
      width: 100%;
      /* Full width */
      z-index: 1000;
      background-color: rgba(0, 0, 0, 0.9);
      /* Hitam dengan transparansi */
      transition: background-color 0.3s ease, transform 0.3s ease;
      transform-origin: center top;
      /* Tetap di tengah saat zoom */
    }

    /* Navbar menjadi lebih transparan saat di-hover */
    .navbar:hover {
      background-color: rgba(0, 0, 0, 0.5);
    }

    /* Efek zoom in dan zoom out */
    .navbar.zoom-in {
      transform: scale(1.05);
    }

    .navbar.zoom-out {
      transform: scale(1) translateY(-10px);
      /* Tetap full-width dan turun sedikit */
    }

    .navbar-brand img {
      max-width: 200px;
    }

    .navbar-nav .nav-link {
      padding: 8px 15px;
    }

    footer {
      background-color: #092635;
      color: white;
      padding: 20px;
    }

    .social-icons img {
      width: 30px;
      margin-right: 10px;
    }
  </style>
</head>

<body>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="bg-white text-dark p-4 text-center rounded shadow mb-4">
          <h2>PAKET KURSUS ONLINE 1</h2>
          <p>Langganan 1 bulan</p>
          <p>Penukaran 100 API</p>
          <button
            class="btn btn-dark"
            onclick="handleExchange(100)">
            Tukar
          </button>
        </div>

        <div class="bg-white text-dark p-4 text-center rounded shadow mb-4">
          <h2>PAKET KURSUS ONLINE 2</h2>
          <p>Langganan 3 bulan</p>
          <p>Penukaran 150 API</p>
          <button
            class="btn btn-dark"
            onclick="handleExchange(150)">
            Tukar
          </button>
        </div>

        <div class="bg-white text-dark p-4 text-center rounded shadow mb-4">
          <h2>PAKET KURSUS ONLINE 3</h2>
          <p>Langganan 6 bulan</p>
          <p>Penukaran 200 API</p>
          <button
            class="btn btn-dark"
            onclick="handleExchange(200)">
            Tukar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script>
    function handleExchange(apiRequired) {
      const availableApi = 7; // Replace with actual value
      if (availableApi >= apiRequired) {
        alert("Penukaran telah berhasil");
      } else {
        alert("Penukaran tidak berhasil. API belum mencukupi.");
      }
    }
  </script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>