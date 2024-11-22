<?php
require 'config.php'; // Koneksi database

// Tangkap nilai package dari URL
$package = isset($_GET['package']) ? (int)$_GET['package'] : 1;

// Query untuk mengambil data paket berdasarkan ID
$query = "SELECT * FROM paket WHERE id_paket = :id_paket";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_paket', $package, PDO::PARAM_INT);
$stmt->execute();
$paket = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika paket tidak ditemukan, redirect ke halaman lain atau tampilkan error
if (!$paket) {
  die("Paket tidak ditemukan.");
}

$nama = htmlspecialchars($paket['nama_paket']);  // Menampilkan nama paket
$harga = number_format($paket['harga_paket'], 0, ',', '.');  // Menampilkan harga paket dengan format
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
      color: white;
    }

    .content-container {
      max-width: 600px;
      margin: auto;
      padding-top: 80px;
    }

    .package-info {
      background-color: #ffffff;
      color: #000;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    footer {
      background-color: #092635;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .social-icons a img {
      width: 30px;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <div class="content-container">
    <div class="package-info text-center">
      <h2>Pembayaran untuk Paket Kursus Online: <?php echo $nama; ?></h2>
      <div class="text-start mt-4">
        <div class="d-flex justify-content-between">
          <span>Harga Paket <?php echo $nama; ?></span>
          <span>Rp <?php echo $harga; ?></span>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <span>Jumlah Tagihan</span>
          <span>Rp <?php echo $harga; ?></span>
        </div>
      </div>
      <div class="d-flex justify-content-between mt-4">
        <a href="product-login.php" class="btn btn-outline-dark">Kembali</a>
        <a href="metode-pembayaran.php?package=<?php echo $package; ?>" class="btn btn-dark">Bayar</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="social-icons mb-3">
        <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
        <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
        <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
        <a href="#"><img src="images/instagram-icon.png" alt="Instagram" /></a>
      </div>
      <nav>
        <a href="index.php" class="me-3 text-decoration-none">Home</a>
        <a href="aboutUs.php" class="me-3 text-decoration-none">About Us</a>
        <a href="product.php" class="me-3 text-decoration-none">Product</a>
        <a href="profil.php" class="text-decoration-none">Login</a>
      </nav>
      <p class="mt-3">&copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>