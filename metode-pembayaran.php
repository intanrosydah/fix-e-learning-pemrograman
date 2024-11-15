<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Langganan</title>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
      color: white;
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
</head>

<body>
  <?php
  // Tangkap nilai package dari halaman sebelumnya (POST atau GET)
  $package = isset($_POST['package']) && in_array($_POST['package'], [1, 2, 3]) ? (int)$_POST['package'] : (isset($_GET['package']) ? (int)$_GET['package'] : 1);

  // Daftar nama dan harga paket
  $namaPaket = ["1 Bulan", "3 Bulan", "6 Bulan"];
  $hargaPaket = ["1.000.000", "3.000.000", "5.100.000"];

  // Tentukan nama dan harga sesuai pilihan
  $nama = $namaPaket[$package - 1];
  $harga = $hargaPaket[$package - 1];
  ?>

  <!-- Paket Langganan dan Biaya -->
  <div class="container text-center text-white py-5">
    <h1 class="display-6">Paket Langganan <?php echo $nama; ?></h1>
    <p class="fs-3">Biaya: <strong>Rp <?php echo $harga; ?></strong></p>
  </div>

  <!-- Konten Utama -->
  <main class="container mb-3">
    <section class="text-center bg-light rounded-3 shadow-lg p-4 mx-auto" style="max-width: 800px">
      <!-- Metode Pembayaran -->
      <div class="payment-method mb-4 text-dark">
        <h3 class="my-4">Metode Pembayaran</h3>
        <div class="d-flex flex-column align-items-center">
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" id="va_bca" name="payment_method" />
            <label class="form-check-label" for="va_bca">
              <img src="images/logobca.png" alt="BCA Logo" class="img-fluid" style="width: 100px; transition: transform 0.2s" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" />
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" id="va_bni" name="payment_method" />
            <label class="form-check-label" for="va_bni">
              <img src="images/logobni.png" alt="BNI Logo" class="img-fluid" style="width: 100px; transition: transform 0.2s" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" />
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" id="va_mandiri" name="payment_method" />
            <label class="form-check-label" for="va_mandiri">
              <img src="images/logomandiri.png" alt="Mandiri Logo" class="img-fluid" style="width: 100px; transition: transform 0.2s" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" />
            </label>
          </div>
        </div>
      </div>

      <!-- Tombol Pembayaran -->
      <div class="payment-button my-4">
        <a href="bayar-sekarang.php?package=<?php echo $package; ?>" class="btn btn-dark btn-md">Bayar Sekarang</a>
      </div>

      <!-- Instruksi Pembayaran -->
      <div class="shadow bg-light text-dark rounded p-3 my-5 mx-auto" style="max-width: 400px">
        <h5>Instruksi Pembayaran</h5>
        <p>
          Setelah memilih metode pembayaran, silakan transfer ke Virtual Account yang tersedia sesuai dengan pilihan Anda. Pembayaran akan diproses secara otomatis setelah transfer berhasil dilakukan.
        </p>
      </div>
    </section>
  </main>

  <!-- Tombol Kembali -->
  <div class="container text-center my-5">
    <a href="product-login.php" class="btn btn-outline-light">Kembali</a>
  </div>

  <?php require 'footer.php'; ?>
</body>

</html>