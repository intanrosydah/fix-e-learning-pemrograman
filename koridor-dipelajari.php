<?php
require 'header-login.php';

// Ambil kelas yang dipilih dari URL
$kelasDipilih = isset($_GET['kelas']) ? $_GET['kelas'] : 'Kelas tidak ditemukan';
?>

<body class="py-5 d-flex flex-column min-vh-100">

  <!-- Konten Utama -->
  <div class="container my-5 flex-grow-1">
    <h2 class="text-white mb-4">Koridor Kelas: <?php echo htmlspecialchars($kelasDipilih); ?></h2>

    <!-- Kelas 1 -->
    <div class="card bg-light mb-5">
      <div class="card-body d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0"><?php echo htmlspecialchars($kelasDipilih); ?></h4>
        <a href="belajar.php" class="btn btn-dark">Belajar</a>
      </div>
      <div class="card-footer">
        <p class="mb-2 mt-2">Terus belajar dan praktikkan ilmu</p>
        <button class="btn btn-secondary mt-3 mb-4" disabled>
          Lihat Sertifikat
        </button>
      </div>
    </div>
  </div>

  <?php
  require 'footer.php';
  ?>

</body>