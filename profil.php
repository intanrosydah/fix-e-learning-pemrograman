<?php
session_start();
include 'config.php'; // File koneksi database
include 'header-login.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: loginfix.php");
  exit();
}

// Ambil data pengguna berdasarkan sesi
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email, foto_profil FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Periksa apakah data pengguna ditemukan
if (!$user) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />

  <style>
    body {
      background-image: url("images/bg_profil.jpg");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      font-family: "Montserrat", sans-serif;
      color: #000;
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

    footer {
      background-color: #092635;
      color: white;
      padding: 20px;
    }

    .social-icons a img {
      width: 30px;
      margin-right: 10px;
    }

    .profile-image {
      width: 150px;
      height: 150px;
      object-fit: cover;
    }

    .profile-container {
      padding-top: 100px;
    }

    .profile-header h1 {
      margin: 0;
      position: relative;
    }

    .profile-section {
      margin-top: 30px;
    }

    .profile-section img {
      margin-bottom: 20px;
    }

    .form-control {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="profil.php">
        <img src="images/new-logo.png" alt="Logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="product-login.php">Product</a></li>
          <li class="nav-item"><a class="nav-link" href="progress.php">Progress</a></li>
          <li class="nav-item"><a class="nav-link" href="daily-coding.php">Daily Coding</a></li>
          <li class="nav-item"><a class="nav-link active" href="profil.php">Profil</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Profile Container -->
  <div class="profile-container">
    <div class="container text-center py-5">
      <div class="bg-white text-dark rounded shadow p-3" style="max-width: 600px; margin: 50px auto;">
        <div class="profile-header">
          <h1>PROFIL</h1>
        </div>

        <div class="profile-section">
          <!-- Foto Profil -->
          <div class="text-center">
            <img id="profileImage" src="<?php echo $user['foto_profil'] ? 'data:image/jpeg;base64,' . base64_encode($user['foto_profil']) : 'images/default_profile.jpg'; ?>" alt="Foto Profil" class="profile-image rounded" />
            <p>FOTO PROFIL</p>
            <h3 class="mt-3"><?= htmlspecialchars($user['name']); ?></h3>
            <p><?= htmlspecialchars($user['email']); ?></p>
            <!-- Tombol Edit -->
            <a href="profil-edit.php" class="btn btn-dark my-5">Edit Profil</a>
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
      <p class="mt-3">&copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const imageInput = document.getElementById("imageInput");
    const profileImage = document.getElementById("profileImage");

    imageInput.addEventListener("change", function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

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