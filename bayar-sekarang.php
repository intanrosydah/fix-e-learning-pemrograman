<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
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
      <h1 class="display-6">Pembayaran Berhasil Dikonfirmasi</h1>
      <p class="fs-5 mt-3">
        Anda telah memilih metode pembayaran melalui Virtual Account.
      </p>
      <p class="fs-5">
        Silahkan transfer ke nomor Virtual Account di bawah ini:
      </p>
    </div>
    <!-- Konten Utama -->
    <main class="container mb-5">
      <section
        class="bg-white rounded-3 shadow-lg p-4 mx-auto"
        style="max-width: 800px"
      >
        <!-- Detail Virtual Account -->
        <div
          class="shadow bg-light text-dark rounded p-3 my-5 mx-auto"
          style="max-width: 400px"
        >
          <h3 class="text-center">Virtual Account Number</h3>
          <p class="text-center fs-4 fw-bold">1234 5678 9101 1121</p>
          <p class="text-center fs-5">
            Total Pembayaran: <strong>Rp 1.000.000</strong>
          </p>
        </div>

        <!-- Tombol untuk Menyelesaikan -->
        <div class="text-center mt-4 mb-4">
          <a href="pembayaran-selesai.html" class="btn btn-dark btn-md"
            >Selesaikan Pembayaran</a
          >
        </div>

        <!-- Instruksi Pembayaran -->
        <div>
          <h5 class="text-left mt-5">Instruksi Pembayaran:</h5>
          <ul class="list-unstyled">
            <li>
              1. Buka aplikasi mobile banking, internet banking, atau ATM.
            </li>
            <li>2. Pilih menu transfer ke Virtual Account.</li>
            <li>3. Masukkan nomor Virtual Account di atas.</li>
            <li>
              4. Masukkan jumlah pembayaran sesuai dengan total yang tertera.
            </li>
            <li>5. Ikuti instruksi hingga pembayaran berhasil.</li>
          </ul>
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
          <a href="aboutUs.html" class="me-3 text-decoration-none">About Us</a>
          <a href="product.html" class="me-3 text-decoration-none">Product</a>
          <a href="profil.html" class="text-decoration-none">Login</a>
        </nav>
        <p class="mt-3">
          &copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love
        </p>
      </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
