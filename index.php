<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

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

      .carousel-item img {
        width: 100%;
        height: 500px;
        object-fit: cover;
      }

      .team-member img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        transition: transform 0.3s ease;
      }

      .team-member img:hover {
        transform: scale(1.1);
      }

      /* Modal header style */
      .modal-header {
        border-bottom: none;
      }

      .modal-content {
        background-color: #092635;
        color: white;
      }

      .modal-title {
        font-weight: bold;
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
      .content {
        margin-top: 70px;
      }

      .bg-light {
        background-color: #092635 !important;
        color: white !important;
      }
      .logo-hover {
        transition: transform 0.3s ease;
      }

      .logo-hover:hover {
        transform: scale(1.2);
      }
      section.py-5.text-center {
        padding: 50px 0;
        max-width: 800px;
        margin: 0 auto;
      }

      section.py-5.text-center p.lead {
        margin: 20px 0;
      }
    </style>
  </head>
  <body>
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
              <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="product.html">Product</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="loginfix.html">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Carousel (Image Slider) -->
    <div
      id="carouselExampleIndicators"
      class="carousel slide"
      data-bs-ride="carousel"
    >
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/bg_produk.jpg" class="d-block w-100" alt="Slide 1" />
        </div>
        <div class="carousel-item">
          <img src="images/bg_produk.jpg" class="d-block w-100" alt="Slide 2" />
        </div>
        <div class="carousel-item">
          <img src="images/bg_produk.jpg" class="d-block w-100" alt="Slide 3" />
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Welcome Section -->
    <section class="py-5 text-center">
      <div class="container">
        <h2 class="mb-4">Selamat Datang!</h2>
        <p class="lead">
          AIFYCODE Learning adalah platform e-learning inovatif yang menawarkan
          kursus pemrograman interaktif untuk semua tingkat, mulai dari pemula
          hingga lanjutan. Materi pembelajaran disajikan dalam bentuk modul yang
          dapat diakses fleksibel kapan pun dan di mana pun, memungkinkan Anda
          belajar sesuai dengan waktu yang Anda miliki.
        </p>
      </div>
    </section>
    <!-- About Us Section -->
    <section class="py-5 text-center bg-light" id="about">
      <div class="container">
        <h2 class="mb-4">Tentang AIFYCODE LEARNING</h2>
        <p class="lead">
          AIFYCODE LEARNING adalah platform e-learning inovatif yang menawarkan
          kursus pemrograman interaktif untuk semua tingkat, mulai dari pemula
          hingga lanjutan. Kami berkomitmen untuk menyediakan pengalaman belajar
          yang fleksibel dan menyenangkan, sehingga siswa dapat belajar sesuai
          dengan waktu dan kebutuhan mereka.
        </p>

        <div class="row mt-5">
          <div class="col-md-4">
            <h3>Visi</h3>
            <p>
              Menjadi platform e-learning terdepan di Indonesia yang
              memfasilitasi pembelajaran pemrograman dengan metode yang
              interaktif dan inovatif, sehingga setiap individu dapat
              mengembangkan keterampilan digital mereka.
            </p>
          </div>
          <div class="col-md-4">
            <h3>Misi</h3>
            <ul class="list-unstyled">
              <li>
                ✔ Menyediakan materi pembelajaran yang berkualitas tinggi dan
                relevan dengan perkembangan industri.
              </li>
              <li>
                ✔ Menggunakan teknologi terkini untuk menciptakan pengalaman
                belajar yang interaktif dan menarik.
              </li>
              <li>
                ✔ Memberikan dukungan dan bimbingan yang berkelanjutan kepada
                siswa selama proses belajar mereka.
              </li>
              <li>
                ✔ Membuka akses pendidikan berkualitas untuk semua orang, tanpa
                batasan waktu dan tempat.
              </li>
            </ul>
          </div>
          <div class="col-md-4">
            <h3>Sejarah Berdiri</h3>
            <p>
              AIFYCODE LEARNING didirikan pada tahun 2022 oleh sekelompok
              profesional di bidang teknologi dan pendidikan. Melihat kebutuhan
              yang terus berkembang dalam dunia digital, kami bertekad untuk
              menciptakan platform yang membantu orang-orang dari berbagai latar
              belakang untuk belajar pemrograman dengan cara yang menyenangkan
              dan efektif.
            </p>
          </div>
        </div>

        <h3 class="mt-5">Perusahaan yang Bekerja Sama</h3>
        <div class="d-flex justify-content-around align-items-center mt-3">
          <div class="col-md-3 text-center">
            <a href="https://www.linkedin.com/" target="_blank">
              <img
                src="images/Logo-Linkedin.png"
                alt="Logo LinkedIn"
                class="img-fluid mb-3 logo-hover"
              />
            </a>
          </div>
          <div class="col-md-3 text-center">
            <a href="https://www.bumn.go.id/" target="_blank">
              <img
                src="images/logo-bumn.png"
                alt="Logo BUMN"
                class="img-fluid mb-3 logo-hover"
              />
            </a>
          </div>
          <div class="col-md-3 text-center">
            <a href="https://about.google/intl/ALL_id/" target="_blank">
              <img
                src="images/logo-google.png"
                alt="Logo Google"
                class="img-fluid mb-3 logo-hover"
              />
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Team Section -->
    <section class="py-5 bg-light text-dark">
      <div class="container">
        <h2 class="text-center mb-5">Tim Kami</h2>
        <div class="row">
          <div class="col-md-3 text-center">
            <div class="team-member">
              <img
                src="images/gambar_orang.jpg"
                alt="Nama Orang 1"
                data-bs-toggle="modal"
                data-bs-target="#teamModal1"
              />
              <h5 class="mt-3">Nama Orang 1</h5>
              <p>Jabatan 1</p>
            </div>
          </div>
          <div class="col-md-3 text-center">
            <div class="team-member">
              <img
                src="images/gambar_orang.jpg"
                alt="Nama Orang 2"
                data-bs-toggle="modal"
                data-bs-target="#teamModal2"
              />
              <h5 class="mt-3">Nama Orang 2</h5>
              <p>Jabatan 2</p>
            </div>
          </div>
          <div class="col-md-3 text-center">
            <div class="team-member">
              <img
                src="images/gambar_orang.jpg"
                alt="Nama Orang 3"
                data-bs-toggle="modal"
                data-bs-target="#teamModal3"
              />
              <h5 class="mt-3">Nama Orang 3</h5>
              <p>Jabatan 3</p>
            </div>
          </div>
          <div class="col-md-3 text-center">
            <div class="team-member">
              <img
                src="images/gambar_orang.jpg"
                alt="Nama Orang 4"
                data-bs-toggle="modal"
                data-bs-target="#teamModal4"
              />
              <h5 class="mt-3">Nama Orang 4</h5>
              <p>Jabatan 4</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Team Modal 1 -->
    <div
      class="modal fade"
      id="teamModal1"
      tabindex="-1"
      aria-labelledby="teamModal1Label"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="teamModal1Label">Nama Orang 1</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <img
              src="images/gambar_orang.jpg"
              alt="Nama Orang 1"
              class="img-fluid mb-3"
            />
            <p><strong>Jabatan:</strong> Jabatan 1</p>
            <p>
              <strong>Pendidikan:</strong> Lulusan S1 Sistem Informasi
              Universitas Negeri Surabaya
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Modal 2 -->
    <div
      class="modal fade"
      id="teamModal2"
      tabindex="-1"
      aria-labelledby="teamModal2Label"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="teamModal2Label">Nama Orang 2</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <img
              src="images/gambar_orang.jpg"
              alt="Nama Orang 2"
              class="img-fluid mb-3"
            />
            <p><strong>Jabatan:</strong> Jabatan 2</p>
            <p><strong>Pendidikan:</strong> Lulusan S2 Manajemen Informatika</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Modal 3 -->
    <div
      class="modal fade"
      id="teamModal3"
      tabindex="-1"
      aria-labelledby="teamModal3Label"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="teamModal3Label">Nama Orang 3</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <img
              src="images/gambar_orang.jpg"
              alt="Nama Orang "
              class="img-fluid mb-3"
            />
            <p><strong>Jabatan:</strong> Jabatan 3</p>
            <p><strong>Pendidikan:</strong> Lulusan S2 Manajemen Informatika</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Modal 4 -->
    <div
      class="modal fade"
      id="teamModal4"
      tabindex="-1"
      aria-labelledby="teamModal4Label"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="teamModal4Label">Nama Orang 4</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-center">
            <img
              src="images/gambar_orang.jpg"
              alt="Nama Orang 4"
              class="img-fluid mb-3"
            />
            <p><strong>Jabatan:</strong> Jabatan 4</p>
            <p><strong>Pendidikan:</strong> Lulusan S2 Manajemen Informatika</p>
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
          <a href="#"
            ><img src="images/instagram-icon.png" alt="Instagram"
          /></a>
        </div>
        <nav>
          <a href="index.html" class="me-3 text-decoration-none">Home</a>
          <a href="aboutUs.html" class="me-3 text-decoration-none">About Us</a>
          <a href="product.html" class="me-3 text-decoration-none">Product</a>
          <a href="profil.html" class="text-decoration-none">Login</a>
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
