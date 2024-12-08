<?php
require_once 'config.php'; // Memasukkan koneksi database

$answers = $_POST['answer']; // Jawaban pengguna dari halaman kuis
$total_questions = count($answers); // Total soal yang dijawab
$score = 0;

// Proses penilaian
foreach ($answers as $id_soal => $jawaban) {
    $query = $pdo->prepare("SELECT jawaban_benar FROM soal_kuis WHERE id_soal = ?");
    $query->execute([$id_soal]);
    $jawaban_benar = $query->fetchColumn();

    if ($jawaban === $jawaban_benar) {
        $score += 100 / $total_questions; // Skor setiap soal benar
    }
}

$final_score = round($score, 2); // Membulatkan skor
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modul 1 - Score</title>

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
        margin: 0;
      }

      .modal-content {
        background-color: white;
        padding: 50px;
        padding-bottom: 70px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .modal-content h2 {
        color: #333;
        font-size: 30px;
        margin-bottom: 20px;
      }

      .modal-content h1 {
        font-size: 120px;
        margin: 20px 0;
        color: black; /* Ubah warna menjadi hitam */
      }

      .thumbs-container {
        display: flex;
        justify-content: center;
        gap: 10px; /* Jarak antar gambar */
        margin-bottom: 20px;
      }

      .thumbs-container img {
        width: 65px; /* Ukuran gambar */
      }

      .btn-custom {
  padding: 10px 40px;
  font-size: 16px;
  background-color: #2a3a5b;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-custom:hover {
  background-color: grey; /* Warna hover menjadi grey */
}

    </style>
  </head>
  <body>
    <!-- Modal Bootstrap -->
    <div class="modal d-block" tabindex="-1" id="scoreModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Container untuk 3 gambar jempol -->
          <div class="thumbs-container">
            <img src="images/jempol.png" alt="Jempol 1" />
            <img src="images/jempol.png" alt="Jempol 2" />
            <img src="images/jempol.png" alt="Jempol 3" />
          </div>
          <h2>SCORE</h2>
          <!-- Menampilkan skor akhir -->
          <h1><?= $final_score; ?></h1>
          <button
            class="btn btn-custom"
            onclick="window.location.href='belajar.php'"
          >
            Lanjut
          </button>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
