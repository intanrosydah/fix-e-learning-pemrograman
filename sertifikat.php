<?php
include 'header-login.php';
require 'config.php';

$message = '';
$gambar_sertifikat = ''; // Default value is empty

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
  try {
    // Get the username from the input
    $username = $_POST['username'];

    // Query to find the certificate by username
    $query = "SELECT sertifikat.gambar_sertifikat 
              FROM sertifikat 
              JOIN progres_kelas  ON sertifikat.id_progres = progres_kelas.id_progres
              JOIN user ON progres_kelas.id_user = user.id
              WHERE user.username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['gambar_sertifikat']) {
      // Ambil data BLOB gambar sertifikat
      $gambar_sertifikat = $result['gambar_sertifikat'];

      // Base64 encode data gambar untuk ditampilkan
      $base64_image = base64_encode($gambar_sertifikat);
    } else {
      $message = "Sertifikat tidak ditemukan!";
    }
  } catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cari Sertifikat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
      color: white;
      padding-top: 100px;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background: #1c3a4d;
      border-radius: 10px;
    }

    .form-outline input {
      background-color: #1e2a35;
      color: white;
      border: 1px solid #3a4e65;
    }

    .form-outline label {
      color: #b0bec5;
    }
  </style>
</head>

<body>
  <section class="vh-100 d-flex align-items-center justify-content-center">
    <div class="form-container">
      <form method="post">
        <h2 class="text-center mb-4">Cari Sertifikat</h2>

        <?php if ($message): ?>
          <div class="alert alert-info">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>

        <!-- Input Username -->
        <div class="form-outline mb-4">
          <input type="text" id="formUsername" class="form-control form-control-lg" name="username"
            placeholder="Masukkan Username" required />
          <label class="form-label text-white" for="formUsername">Username</label>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-lg">
            Cari Sertifikat
          </button>
        </div>
      </form>

      <!-- Sertifikat Section -->
      <section class="bg-white p-4 mt-4 shadow rounded text-center">
        <?php if (isset($base64_image)): ?>
          <!-- Display Certificate Image using base64 encoding -->
          <img src="data:image/jpeg;base64,<?= $base64_image ?>" alt="Sertifikat" style="max-width: 100%; height: auto; object-fit: contain;" />
        <?php else: ?>
          <p class="text-muted">Tidak ada sertifikat yang ditampilkan.</p>
        <?php endif; ?>
      </section>

      <!-- Download Button -->
      <?php if (isset($base64_image)): ?>
        <div class="d-flex justify-content-center mt-3">
          <a href="data:image/jpeg;base64,<?= $base64_image ?>" download="sertifikat.jpg" class="btn btn-dark">
            Download Sertifikat
          </a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", () => {
      const scrollPos = window.scrollY;
      if (scrollPos > 50) {
        navbar.classList.add("zoom-out");
        navbar.classList.remove("zoom-in");
      } else {
        navbar.classList.add("zoom-in");
        navbar.classList.remove("zoom-out");
      }
    });
  </script>
</body>

</html>