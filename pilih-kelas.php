<?php
require 'config.php'; // Include the database connection file

// Tangkap parameter package dari URL
$package = isset($_GET['package']) && in_array($_GET['package'], [1, 2, 3]) ? (int)$_GET['package'] : 1;

// Tentukan jumlah kelas yang bisa dipilih berdasarkan paket
$jumlahKelas = [3, 6, 9];  // 1 bulan = 3 kelas, 3 bulan = 6 kelas, 6 bulan = 9 kelas
$kelasMax = $jumlahKelas[$package - 1];  // Sesuaikan jumlah kelas yang bisa dipilih

// Query untuk mengambil data kelas dari database
$query = "SELECT id_kelas, nama_kelas FROM kelas";
$stmt = $pdo->prepare($query);
$stmt->execute();
$kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Jika tidak ada kelas yang ditemukan, beri pesan error
if (!$kelas) {
  die("Kelas tidak ditemukan.");
}
?>

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
        // Loop untuk menampilkan checkbox kelas
        foreach ($kelas as $index => $kelasItem) {
          echo '<div class="form-check">
                    <input type="checkbox" class="form-check-input pilihan" id="kelas' . $kelasItem['id_kelas'] . '" />
                    <label class="form-check-label" for="kelas' . $kelasItem['id_kelas'] . '">' . $kelasItem['nama_kelas'] . '</label>
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
        // Nonaktifkan tombol konfirmasi jika lebih dari kelas maksimal
        document.getElementById("confirmModal").querySelector(".btn-primary").disabled = true;
      } else if (checkboxes.length < <?php echo $kelasMax; ?>) {
        message = "Silakan pilih <?php echo $kelasMax; ?> Kelas.";
        // Nonaktifkan tombol konfirmasi jika kurang dari kelas maksimal
        document.getElementById("confirmModal").querySelector(".btn-primary").disabled = true;
      } else {
        message = "Kelas berhasil diambil!";
        // Aktifkan tombol konfirmasi jika jumlah kelas yang dipilih sesuai
        document.getElementById("confirmModal").querySelector(".btn-primary").disabled = false;
      }

      // Tampilkan pesan di modal
      document.getElementById("modalBody").innerText = message;

      // Jika kelas berhasil diambil, siapkan pengalihan ke progress.php dengan query string
      if (checkboxes.length >= <?php echo $kelasMax; ?>) {
        document.getElementById("confirmModal").querySelector(".btn-primary").onclick = function() {
          // Membuat query string dengan kelas yang dipilih
          const queryString = selectedClasses.map(item => `kelas[]=${encodeURIComponent(item)}`).join("&");

          // Mengarahkan ke halaman progress.php dengan query string
          window.location.href = "progress.php?" + queryString;
        };
      }
    }
  </script>
</body>

</html>