<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progress Belajar</title>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
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
     background-color: rgba(9, 38, 53, 0.5); /* Transparansi */
     backdrop-filter: blur(10px); /* Efek blur */
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
     transform: scale(1) translateY(-10px); /* Tetap full-width dan turun sedikit */
   }

   .navbar-brand img {
     max-width: 200px;
   }

   .navbar-nav .nav-link {
     padding: 8px 15px;
   }
 
   .class-section {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }
    .class-box {
      width: 45%; /* Adjust width as needed */
    }
     .class-item {
      margin-bottom: 15px;
    }

   body {
     font-family: "Montserrat", sans-serif;
     background-color: #092635;
   }
   .class-item {
     margin-bottom: 20px; /* Jarak antar kelas */
   }
   .class-item button {
     margin-top: 10px; /* Jarak antara teks dan tombol */
   }
   .class-section {
     display: flex;
     justify-content: space-between; /* Untuk meratakan kotak */
   }
   .class-section .class-box {
     flex: 1; /* Membuat setiap kotak mengambil ruang yang sama */
     margin: 0 10px; /* Jarak antar kotak */
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
 
  <body class="py-5">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="images/new-logo.png" alt="Logo" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
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
  <body class="text-white">
    <div class="container text-center py-5">
        <div class="class-section">
          <!-- Kelas yang Dipelajari -->
          <div class="class-box">
            <h3>Kelas yang Dipelajari</h3>
            <div class="class-item">
              <div class="bg-white text-dark rounded shadow p-4">
                <span>Belajar Dasar Penggunaan AI</span>
                <button class="btn btn-primary mt-2" onclick="window.location.href='koridor-dipelajari.php'">Koridor Kelas</button>
              </div>
            </div>
            <div class="class-item">
              <div class="bg-white text-dark rounded shadow p-4">
                <span>Belajar Dasar Pemrograman Web</span>
                <button class="btn btn-primary mt-2" onclick="window.location.href='koridor-diselesaikan.php'">Koridor Kelas</button>
              </div>
            </div>
            <div class="class-item">
              <div class="bg-white text-dark rounded shadow p-4">
                <span>Belajar Dasar Machine Learning</span>
                <button class="btn btn-primary mt-2" onclick="window.location.href='koridor-machine-learning.php'">Koridor Kelas</button>
              </div>
            </div>
          </div>
  
          <!-- Kelas yang Diselesaikan -->
          <div class="class-box">
            <h3>Kelas yang Diselesaikan</h3>
            <div class="class-item">
              <div class="bg-white text-dark rounded shadow p-4">
                <span>Belajar Dasar Pemrograman</span>
                <button class="btn btn-primary mt-2" onclick="window.location.href='koridor-diselesaikan.php'">Koridor Kelas</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <!-- Footer -->
  <footer class="text-center">
    <div class="container">
      <div class="social-icons mb-3">
        <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
        <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
        <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
        <a href="#"
          ><img src="images/instagram-icon.png" alt="Instagram"
        /></a>
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
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
      