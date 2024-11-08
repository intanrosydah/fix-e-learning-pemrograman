<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran Selesai</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
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
    <div class="container text-center text-white py-5">
      <h1 class="display-6">Terima Kasih</h1>
    </div>
    <!-- Konten Utama -->
    <main class="container mb-5" style="max-width: 800px">
      <section class="text-center bg-light rounded shadow p-4">
        <p class="text-center fs-5 mt-4">
          Pembayaran paket langganan 1 bulan Anda sebesar
          <strong>Rp 1.000.000</strong> telah berhasil.
        </p>
        <p class="text-center fs-5 mt-2">
          Anda sekarang dapat menikmati layanan kami.
        </p>

        <!-- Informasi Langganan -->
        <div
          class="shadow bg-light text-dark rounded-3 p-3 my-5 mx-auto"
          style="max-width: 400px"
        >
          <h3>Detail Langganan</h3>
          <p>Paket Langganan: <strong>1 Bulan</strong></p>
          <p>Tanggal Mulai: <strong>19 September 2024</strong></p>
          <p>Tanggal Berakhir: <strong>19 Oktober 2024</strong></p>
        </div>

        <!-- Tombol mulai belajar -->
        <div class="my-4">
          <a href="pilih-kelas.php" class="btn btn-dark btn-md"
            >Mulai Belajar</a
          >
        </div>
      </section>
    </main>

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
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
