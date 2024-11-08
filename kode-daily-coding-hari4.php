<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Status Pengiriman Kode</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
    rel="stylesheet"
  />

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
   <nav class="navbar navbar-expand-lg navbar-dark ">
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
            <a class="nav-link" href="progress.php">Progress</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="daily-coding.php"
              >Daily Coding</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profil.php">Profil</a>
          </li>
         </ul>
       </div>
     </div>
   </nav>

    <!-- Konten Utama -->
    <main class="pt-5 mt-5">
      <div class="container">
      <section class="text-center text-dark bg-light rounded p-4">
        <h2>Kode Anda Telah Dikirim!</h2>
        <p>
          Terima kasih telah mengirimkan kode Anda. Kami sedang memprosesnya dan
          akan memberikan umpan balik segera.
        </p>

        <!-- Status Umpan Balik -->
        <div class="status mt-4">
          <h3>Status:</h3>
          <p class ="text-primary">Kode berhasil dikirim!</p>
          <p class ="text-primary">
            Anda akan mendapatkan 4 Api setelah kode Anda berhasil diverifikasi.
          </p>
        </div>

        <!-- Tombol Kembali ke Tantangan -->
        <div class="mt-4">
          <a href="daily-coding-hari5.php" class="btn btn-dark">Kembali ke Tantangan</a>
        </div>
      </section>
    </main>

        <!-- Footer -->
    <footer class="text-center">
      <div class="container">
        <div class="social-icons mb-3">
          <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
          <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
          <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
          <a href="#"><img src="images/instagram-icon.png" alt="Instagram"/></a>
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