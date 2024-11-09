<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
    }
    footer {
      background-color: #092635;
      color: white;
      padding: 20px;
    }

    .social-icons a img {
      width: 30px;
      margin-right: 10px;
    }
  </style>
  <body>
  <body class="text-white">
    <div class="container text-center py-5">
      <div class="bg-white text-dark rounded shadow p-4">
        <h2 class="mb-4">Pembayaran untuk Paket Kursus Online 1</h2>
        <div class="row justify-content-center">
          <div class="col-md-6 text-start">Harga 1 Bulan</div>
          <div class="col-md-6 text-end">Rp 1,000,000</div>
        </div>
        <hr class="my-4" />
        <div class="row justify-content-center">
          <div class="col-md-6 text-start">Jumlah Tagihan</div>
          <div class="col-md-6 text-end">Rp 1,000,000</div>
        </div>
        <div class="d-flex justify-content-between mt-4">
          <a href="product.php" class="btn btn-outline-dark">Kembali</a>
          <button
            type="button"
            class="btn btn-dark"
            onclick="window.location.href='metode-pembayaran.php'"
          >
            Bayar
          </button>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
      <div class="container">
        <div class="social-icons mb-3">
          <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
          <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
          <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
          <a href="#"
            ><img src="images/instagram-icon.png" alt="Instagram"
          /></a>
        </div>
        <nav>
          <a href="index.php" class="me-3 text-decoration-none">Home</a>
          <a href="aboutUs.php" class="me-3 text-decoration-none">About Us</a>
          <a href="product.php" class="me-3 text-decoration-none">Product</a>
          <a href="profil.php" class="text-decoration-none">Login</a>
        </nav>
        <p class="mt-3">
          &copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love
        </p>
      </div>
    </footer>
  </body>
</html>
