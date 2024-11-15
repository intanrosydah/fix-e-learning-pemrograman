<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Pembayaran</title>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
    rel="stylesheet" />
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
  <?php
  // Tangkap nilai package dari URL
  $package = isset($_GET['package']) && in_array($_GET['package'], [1, 2, 3]) ? (int)$_GET['package'] : 1;

  // Daftar nama dan harga paket
  $namaPaket = ["1 Bulan", "3 Bulan", "6 Bulan"];
  $hargaPaket = ["1.000.000", "3.000.000", "5.100.000"];

  // Tentukan nama dan harga sesuai pilihan
  $nama = $namaPaket[$package - 1];
  $harga = $hargaPaket[$package - 1];
  ?>

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
      style="max-width: 800px">
      <!-- Detail Virtual Account -->
      <div
        class="shadow bg-light text-dark rounded p-3 my-5 mx-auto"
        style="max-width: 400px">
        <h3 class="text-center">Virtual Account Number</h3>
        <p class="text-center fs-4 fw-bold">1234 5678 9101 1121</p>
        <p class="text-center fs-5">
          Total Pembayaran: <strong>Rp <?php echo $harga; ?></strong>
        </p>
      </div>

      <!-- Tombol untuk Menyelesaikan -->
      <div class="text-center mt-4 mb-4">
        <a href="pembayaran-selesai.php?package=<?php echo $package; ?>" class="btn btn-dark btn-md">
          Selesaikan Pembayaran
        </a>
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

  <?php
  require 'footer.php';
  ?>

  <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>