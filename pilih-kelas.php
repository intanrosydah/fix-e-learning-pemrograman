<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Kelas</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      background-color: #092635;
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
  <body>
    <div class="container text-center text-white py-5">
      <h1 class="display-6">Pilih Kelas</h1>
      <p class="fs-5 mt-3">
        Silakan pilih maksimal <strong>3 Kelas</strong> dari daftar berikut.
      </p>
    </div>
    <!-- Konten Utama -->
    <main class="container mb-4">
      <section
        class="bg-white rounded-3 shadow p-4 mx-auto"
        style="max-width: 600px"
      >
        <h2 class="text-center mt-3 mb-3">Daftar Kelas</h2>
        <!-- Pilihan Kelas -->
        <div class="bg-light shadow rounded-3 p-3 mx-auto">
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas1"
            />
            <label class="form-check-label" for="kelas1"
              >Belajar Dasar AI</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas2"
            />
            <label class="form-check-label" for="kelas2"
              >Belajar Dasar Machine Learning</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas3"
            />
            <label class="form-check-label" for="kelas3"
              >Belajar Dasar Pemrograman</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas4"
            />
            <label class="form-check-label" for="kelas4"
              >Belajar Dasar Pemrograman Web</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas5"
            />
            <label class="form-check-label" for="kelas5"
              >Belajar Dasar Pemrograman Game</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas6"
            />
            <label class="form-check-label" for="kelas6"
              >Belajar Bahasa Python</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas7"
            />
            <label class="form-check-label" for="kelas7"
              >Belajar Bahasa CSS</label
            >
          </div>
          <div class="form-check">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas8"
            />
            <label class="form-check-label" for="kelas8"
              >Belajar Bahasa Java</label
            >
          </div>
          <div class="form-check mb-5">
            <input
              type="checkbox"
              class="form-check-input pilihan"
              id="kelas9"
            />
            <label class="form-check-label" for="kelas9"
              >Belajar Bahasa C++</label
            >
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="mt-5 mb-4 d-flex justify-content-center mt-4">
          <button
            class="btn btn-dark"
            data-bs-toggle="modal"
            data-bs-target="#confirmModal"
            onclick="prepareSubmission()"
          >
            Ambil Kelas
          </button>
        </div>
      </section>
    </main>

    <!-- Modal Konfirmasi -->
    <div
      class="modal fade"
      id="confirmModal"
      tabindex="-1"
      aria-labelledby="confirmModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">
              Konfirmasi Pengambilan Kelas
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body" id="modalBody">
            <!-- Pesan akan ditampilkan di sini -->
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Batal
            </button>
            <button
              type="button"
              class="btn btn-primary"
              onclick="submitKelas()"
            >
              Konfirmasi
            </button>
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

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function prepareSubmission() {
        const checkboxes = document.querySelectorAll(".pilihan:checked");
        let message = "";

        if (checkboxes.length > 3) {
          message = "Anda hanya boleh memilih maksimal 3 Kelas.";
        } else if (checkboxes.length < 3) {
          message = "Silakan pilih 3 Kelas.";
        } else {
          message = "Kelas berhasil diambil!";
        }

        // Tampilkan pesan di modal
        document.getElementById("modalBody").innerText = message;
      }

      function submitKelas() {
        const checkboxes = document.querySelectorAll(".pilihan:checked");
        if (checkboxes.length === 3) {
          window.location.href = "progress.php"; // Mengarahkan ke halaman progress setelah konfirmasi
        }
      }
    </script>
  </body>
</html>
