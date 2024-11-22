<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Progress Belajar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
</head>

<style>
  body {
    font-family: "Montserrat", sans-serif;
    background-color: #092635;
    color: white;
  }

  .navbar {
    padding: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    background-color: rgba(9, 38, 53, 0.5);
    backdrop-filter: blur(10px);
    transition: background-color 0.3s ease, transform 0.3s ease;
    transform-origin: center top;
  }

  .navbar:hover {
    background-color: rgba(0, 0, 0, 0.5);
  }

  .navbar.zoom-in {
    transform: scale(1.05);
  }

  .navbar.zoom-out {
    transform: scale(1) translateY(-10px);
  }

  .navbar-brand img {
    max-width: 200px;
  }

  .navbar-nav .nav-link {
    padding: 8px 15px;
  }

  .class-section {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    flex-wrap: wrap;
  }

  .class-box {
    width: 45%;
    margin-bottom: 20px;
  }

  /* Class Item Styles */
  .class-item {
    margin-bottom: 20px;
  }

  .class-item-wrapper {
    position: relative;
    background-color: #fff;
    color: #000;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .class-item-wrapper span {
    display: block;
    text-align: left;
    /* Align class title to the left */
  }

  .class-item-wrapper button {
    margin-top: 10px;
    position: absolute;
    right: 10px;
    bottom: 10px;
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

  /* Media Query for responsiveness */
  @media (max-width: 768px) {
    .class-section {
      flex-direction: column;
      align-items: center;
    }

    .class-box {
      width: 90%;
      /* Make boxes take full width on smaller screens */
    }
  }
</style>

<body class="py-5">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="images/new-logo.png" alt="Logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="progress.php">Progress</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="daily-coding.php">Daily Coding</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profil.php">Profil</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container text-center py-5">
    <?php
    // Ambil kelas yang dipilih dari URL (jika ada)
    $kelasDipilih = isset($_GET['kelas']) ? $_GET['kelas'] : [];
    ?>
    <div class="class-section">
      <!-- Kelas yang Dipelajari -->
      <div class="class-box">
        <h3>Kelas yang Dipelajari</h3>
        <?php if (empty($kelasDipilih)): ?>
          <p>Tidak ada kelas yang dipilih.</p>
        <?php else: ?>
          <?php foreach ($kelasDipilih as $kelas): ?>
            <div class="class-item">
              <div class="class-item-wrapper">
                <span><?php echo htmlspecialchars($kelas); ?></span>
                <button class="btn btn-dark" onclick="window.location.href='koridor-dipelajari.php?kelas=<?php echo urlencode($kelas); ?>'">Koridor Kelas</button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Kelas yang Diselesaikan -->
      <div class="class-box">
        <h3>Kelas yang Diselesaikan</h3>
        <div class="class-item">
          <div class="class-item-wrapper">
            <span>Belajar Dasar Pemrograman</span>
            <button class="btn btn-dark" onclick="window.location.href='koridor-diselesaikan.php'">Koridor Kelas</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center">
    <div class="container">
      <div class="social-icons mb-3">
        <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
        <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
        <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
        <a href="#"><img src="images/instagram-icon.png" alt="Instagram" /></a>
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>