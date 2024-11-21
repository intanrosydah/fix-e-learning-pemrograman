<?php
require 'config.php'; // Koneksi database

// Tangkap parameter package dari URL
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

// Menghitung tanggal mulai dan tanggal berakhir
$tanggalMulai = new DateTime();
$tanggalBerakhir = clone $tanggalMulai;

if ($package == 1) {
  $tanggalBerakhir->modify('+1 month');
} elseif ($package == 2) {
  $tanggalBerakhir->modify('+3 months');
} elseif ($package == 3) {
  $tanggalBerakhir->modify('+6 months');
}

$tanggalMulaiFormatted = $tanggalMulai->format('d F Y');
$tanggalBerakhirFormatted = $tanggalBerakhir->format('d F Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Selesai</title>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/footer.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
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
        Pembayaran paket langganan <?php echo $nama; ?> Anda sebesar
        <strong>Rp <?php echo $harga; ?></strong> telah berhasil.
      </p>
      <p class="text-center fs-5 mt-2">
        Anda sekarang dapat menikmati layanan kami.
      </p>

      <!-- Informasi Langganan -->
      <div class="shadow bg-light text-dark rounded-3 p-3 my-5 mx-auto" style="max-width: 400px">
        <h3>Detail Langganan</h3>
        <p>Paket Langganan: <strong><?php echo $nama; ?></strong></p>
        <p>Tanggal Mulai: <strong><?php echo $tanggalMulaiFormatted; ?></strong></p>
        <p>Tanggal Berakhir: <strong><?php echo $tanggalBerakhirFormatted; ?></strong></p>
      </div>

      <!-- Tombol mulai belajar -->
      <div class="my-4">
        <a href="pilih-kelas.php?package=<?php echo $package; ?>" class="btn btn-dark btn-md">
          Mulai Belajar
        </a>
    </section>
  </main>

  <?php require 'footer.php'; ?>

  <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>