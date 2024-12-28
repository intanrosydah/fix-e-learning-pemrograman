<?php
session_start();
include 'config.php'; // File koneksi database
require 'header-login.php';

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
  <?php require 'footer.php'; ?>
</body>

</html>