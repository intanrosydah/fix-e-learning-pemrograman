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
    rel="stylesheet" />
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
  <?php
  // Tangkap parameter package dari URL
  $package = isset($_GET['package']) && in_array($_GET['package'], [1, 2, 3]) ? (int)$_GET['package'] : 1;

  // Tentukan jumlah kelas yang bisa dipilih berdasarkan paket
  $jumlahKelas = [3, 6, 9];  // 1 bulan = 3 kelas, 3 bulan = 6 kelas, 6 bulan = 9 kelas
  $kelasMax = $jumlahKelas[$package - 1];  // Sesuaikan jumlah kelas yang bisa dipilih
  ?>

  <div class="container text-center text-white py-5">
    <h1 class="display-6">Pilih Kelas</h1>
    <p class="fs-5 mt-3">
      Silakan pilih maksimal <strong><?php echo $kelasMax; ?> Kelas</strong> dari daftar berikut.
    </p>
  </div>
  <!-- Konten Utama -->
  <main class="container mb-4">
    <section
      class="bg-white rounded-3 shadow p-4 mx-auto"
      style="max-width: 600px">
      <h2 class="text-center mt-3 mb-3">Daftar Kelas</h2>
      <!-- Pilihan Kelas -->
      <div class="bg-light shadow rounded-3 p-3 mx-auto">
        <?php
        // Daftar kelas yang tersedia
        $kelas = [
          "Belajar Dasar AI",
          "Belajar Dasar Machine Learning",
          "Belajar Dasar Pemrograman",
          "Belajar Dasar Pemrograman Web",
          "Belajar Dasar Pemrograman Game",
          "Belajar Bahasa Python",
          "Belajar Bahasa CSS",
          "Belajar Bahasa Java",
          "Belajar Bahasa C++"
        ];

        // Loop untuk menampilkan checkbox kelas
        foreach ($kelas as $index => $kelasName) {
          echo '<div class="form-check">
                    <input type="checkbox" class="form-check-input pilihan" id="kelas' . ($index + 1) . '" />
                    <label class="form-check-label" for="kelas' . ($index + 1) . '">' . $kelasName . '</label>
                  </div>';
        }
        ?>
      </div>

      <!-- Tombol Submit -->
      <div class="mt-5 mb-4 d-flex justify-content-center mt-4">
        <button
          class="btn btn-dark"
          data-bs-toggle="modal"
          data-bs-target="#confirmModal"
          onclick="prepareSubmission()">
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
    aria-hidden="true">
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
            aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Pesan akan ditampilkan di sini -->
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Batal
          </button>
          <button
            type="button"
            class="btn btn-primary"
            onclick="submitKelas()">
            Konfirmasi
          </button>
        </div>
      </div>
    </div>
  </div>

  <?php
  require 'footer.php';
  ?>

  <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function prepareSubmission() {
      const checkboxes = document.querySelectorAll(".pilihan:checked");
      let message = "";
      const selectedClasses = [];

      // Menyimpan kelas yang dipilih
      checkboxes.forEach(checkbox => {
        selectedClasses.push(checkbox.nextElementSibling.textContent.trim());
      });

      // Validasi jumlah kelas yang dipilih
      if (checkboxes.length > <?php echo $kelasMax; ?>) {
        message = "Anda hanya boleh memilih maksimal <?php echo $kelasMax; ?> Kelas.";
      } else if (checkboxes.length < <?php echo $kelasMax; ?>) {
        message = "Silakan pilih <?php echo $kelasMax; ?> Kelas.";
      } else {
        message = "Kelas berhasil diambil!";
      }

      // Tampilkan pesan di modal
      document.getElementById("modalBody").innerText = message;

      // Menyimpan kelas yang dipilih ke dalam query string
      const queryString = selectedClasses.map(item => `kelas[]=${encodeURIComponent(item)}`).join("&");
      const url = `progress.php?${queryString}`;

      // Mengarahkan ke halaman progress dengan query string
      document.getElementById("confirmModal").querySelector(".btn-primary").onclick = function() {
        window.location.href = url; // Arahkan ke halaman progress dengan kelas yang dipilih
      };
    }
  </script>

  </script>
</body>

</html>