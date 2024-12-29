<?php
session_start();
require 'header-login.php'; // Memasukkan header
require 'config.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php'); // Redirect ke halaman login jika tidak ada session
  exit();
}

$id_user = $_SESSION['user_id']; // Ambil id_user dari session

// Ambil jumlah total API yang diperoleh dari tabel progres_api berdasarkan user_id
$query = "SELECT SUM(api_diperoleh) AS total_api FROM progres_api WHERE id_user = :id_user";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt->execute();
$totalApi = $stmt->fetchColumn() ?: 0; // Jika null, set ke 0

// Ambil data paket_api dari database
$query = "SELECT * FROM paket_api"; // Ambil semua data paket_api
$stmt = $pdo->prepare($query);
$stmt->execute();
$paketApi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Penukaran API</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />

  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
    rel="stylesheet" />

  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
      color: white;
      margin-top: 100px;
    }

    .content {
      padding-top: 100px;
    }

    .card {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
    }
  </style>
</head>

<body>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <?php foreach ($paketApi as $paket): ?>
          <div class="bg-white text-dark p-4 text-center rounded shadow mb-4">
            <h2><?php echo htmlspecialchars($paket['nama_paket_api']); ?></h2>
            <p>Penukaran: <?php echo htmlspecialchars($paket['api_minimal']); ?> API</p>
            <button class="btn btn-dark" onclick="handleExchange(<?php echo $paket['api_minimal']; ?>)">Tukar</button>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script>
    const availableApi = <?php echo $totalApi; ?>; // Ambil total API dari PHP

    function handleExchange(apiRequired) {
      if (availableApi >= apiRequired) {
        alert("Penukaran telah berhasil");
      } else {
        alert("Penukaran tidak berhasil. API belum mencukupi.");
      }
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>