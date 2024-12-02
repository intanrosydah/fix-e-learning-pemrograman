<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>
  <link
    rel="stylesheet"
    href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <style>
    /* Body background image */
    body {
      background-image: url("images/bg_profil.jpg");
      /* Ganti path dengan path gambar */
      background-size: cover;
      /* Membuat gambar menyesuaikan ukuran halaman */
      background-position: center;
      /* Memposisikan gambar di tengah */
      background-repeat: no-repeat;
      /* Menpengulangan gambar */
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
      /* Transparansi */
      backdrop-filter: blur(10px);
      /* Efek blur */
      transition: background-color 0.3s ease, transform 0.3s ease;
      transform-origin: center top;
    }

    /* Navbar menjadi lebih transparan saat di-hover */
    .navbar:hover {
      background-color: rgba(0, 0, 0, 0.5);
    }

    /* Efek zoom in dan zoom out */
    .navbar.zoom-in {
      transform: scale(1.05);
    }

    .navbar.zoom-out {
      transform: scale(1) translateY(-10px);
      /* Tetap full-width dan turun sedikit */
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
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="profil.php">
        <img src="images/new-logo.png" alt="Logo" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product-login.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="progress.php">Progress</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="daily-coding.php">Daily Coding</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="profil.php">Profil</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="profile-container">

    <body class="bg-dark text-white">
      <div class="container text-center py-5">
        <div class="bg-white text-dark rounded shadow p-3" style="max-width: 600px; margin: 50px auto; ">
          <div class="profile-header">
            <h1 style="margin: 0; position: relative;">PROFIL</h1>
          </div>
          <style>
            .profile-image {
              width: 150px;
              /* Ukuran lebih kecil */
              height: 150px;
              /* Ukuran lebih kecil */
              object-fit: cover;
              /* Memastikan gambar tidak terdistorsi */
            }
          </style>

          <div class="container">
            <div class="profile-section">

              <!-- Foto Profil -->
              <div class="text-center">
                <img
                  id="profileImage"
                  src="images/default_profile.jpg"
                  alt="Foto Profil"
                  class="profile-image rounded" />
                <p>FOTO PROFIL</p>
                <input type="file" id="imageInput" accept="image/*" class="form-control mb-3" />
              </div>

              </style>
              </head>

              <body>
                <?php
                // Koneksi ke database
                $host = "localhost";
                $username = "root";
                $password = ""; // Ganti jika ada password
                $database = "aifycode"; // Nama database Anda
                $conn = new mysqli($host, $username, $password, $database);

                // Periksa koneksi
                if ($conn->connect_error) {
                  die("<p>Koneksi gagal: " . $conn->connect_error . "</p>");
                }

                // Ambil data pengguna berdasarkan ID
                $userId = 1; // Ganti dengan ID pengguna yang sesuai
                $query = "SELECT name, email FROM user WHERE id = $userId";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                  $user = $result->fetch_assoc();
                  $name = $user['name'];
                  $email = $user['email'];
                } else {
                  $name = "coba";
                  $email = "coba@gmail.com";
                }

                $conn->close();
                ?>

                <div class="mb-3">
                  <label for="emailInput" class="form-label">Email</label>
                  <input type="email" class="form-control" id="emailInput" placeholder="Email" value="<?php echo $email; ?>" readonly />
                </div>
                <div class="mb-3">
                  <label for="nameInput" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nameInput" placeholder="Nama Lengkap" value="<?php echo $name; ?>" readonly />
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>



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
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
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