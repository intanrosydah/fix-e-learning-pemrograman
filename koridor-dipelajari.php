<?php
require 'header-login.php';
require 'config.php'; // Pastikan menggunakan koneksi PDO yang telah diatur

// Ambil kelas yang dipilih dari URL
$kelasDipilih = isset($_GET['nama_kelas']) ? $_GET['nama_kelas'] : 'Kelas tidak ditemukan';

// Ambil id_kelas berdasarkan nama_kelas
if ($kelasDipilih != 'Kelas tidak ditemukan') {
    try {
        $query = "SELECT id_kelas FROM kelas WHERE nama_kelas = :nama_kelas";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':nama_kelas' => $kelasDipilih]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);

        // Pastikan kelas ditemukan dan ambil id_kelas
        if ($kelas) {
            $id_kelas = $kelas['id_kelas'];
        } else {
            $id_kelas = null; // Jika kelas tidak ditemukan
        }
    } catch (PDOException $e) {
        die("Error mengambil id_kelas: " . $e->getMessage());
    }
} else {
    $id_kelas = null;
}
?>

<body class="py-5 d-flex flex-column min-vh-100">
  <div class="container my-5 flex-grow-1">
    <h2 class="text-white mb-4">Koridor Kelas</h2>

    <!-- Kelas 1 -->
    <div class="card bg-light mb-5">
      <div class="card-body d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-4"><?php echo htmlspecialchars($kelasDipilih); ?></h4>
        <!-- Pastikan id_kelas ada sebelum membuat link -->
        <?php if ($id_kelas): ?>
          <a href="belajar.php?id_kelas=<?php echo $id_kelas; ?>" class="btn btn-dark">Belajar</a>
        <?php else: ?>
          <span class="text-muted">Kelas tidak ditemukan</span>
        <?php endif; ?>
      </div>
      <div class="card-footer">
        <p class="mb-2 mt-2">Semangat belajarnya yaa!</p>
        <a href="sertifikat.php" class="btn btn-dark mt-3 mb-4 disabled">Lihat Sertifikat</a>
      </div>
    </div>
  </div>

  <?php require 'footer.php'; ?>
</body>
</html>
