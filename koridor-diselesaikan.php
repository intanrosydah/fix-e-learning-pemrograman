<?php
require 'header-login.php';
?>

<body class="py-5 d-flex flex-column min-vh-100">

  <!-- Konten Utama -->
  <div class="container my-5 flex-grow-1">
    <h2 class="text-white mb-4">Koridor Kelas</h2>

    <!-- Kelas 1 -->
    <div class="card bg-light mb-5">
      <div
        class="card-body d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Belajar Dasar Pemrograman</h4>
        <a href="belajar.php" class="btn btn-dark">Belajar Lagi</a>
      </div>
      <div class="card-footer">
        <p class="mb-2 mt-2">Selamat, kamu lulus kelas ini!</p>
        <a href="sertifikat.php" class="btn btn-dark mt-3 mb-4">Lihat Sertifikat</a>
      </div>
    </div>
  </div>

  <?php
  require 'footer.php';
  ?>

</body>

</html>