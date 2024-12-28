<?php
session_start();
require 'header-login.php';
require 'config.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect ke halaman login jika tidak ada session
    exit();
}

$id_user = $_SESSION['user_id']; // Ambil id_user dari session

// Ambil data soal dari database
$query = "SELECT * FROM daily_coding";
$stmt = $pdo->prepare($query);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil total poin API yang diperoleh
$query = "SELECT SUM(api_diperoleh) AS total_api FROM progres_api WHERE id_user = :id_user";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt->execute();
$apiPoints = $stmt->fetchColumn() ?: 0; // Jika null, set ke 0

$feedback = ""; // Feedback untuk user
$activeTab = 1; // Default tab yang aktif
$showModal = false; // Flag untuk menampilkan modal

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input dari form
    $kode_soal = filter_var($_POST['kode_soal'], FILTER_SANITIZE_STRING);
    $jawaban_user = filter_var($_POST['jawaban'], FILTER_SANITIZE_STRING);
    $activeTab = (int)$_POST['day']; // Tab saat ini

    // Dapatkan hari ini berdasarkan tanggal
    $today = date('Y-m-d');

    // Periksa apakah user sudah mengerjakan soal sebelumnya
    $query = "SELECT * FROM progres_api WHERE id_user = :id_user AND tanggal_perolehan = :today";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':today', $today, PDO::PARAM_STR);
    $stmt->execute();
    $doneToday = $stmt->rowCount() > 0;

    // Jika sudah mengerjakan hari ini
    if ($doneToday) {
        $feedback = "Anda sudah menyelesaikan tantangan hari ini.";
        $showModal = false;
    } else {
        // Periksa apakah soal hari ini sudah pernah dikerjakan
        $query = "SELECT COUNT(*) FROM progres_api WHERE id_user = :id_user AND id_daily_coding = :kode_soal";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':kode_soal', $kode_soal, PDO::PARAM_STR);
        $stmt->execute();
        $isAlreadyAnswered = $stmt->fetchColumn();

        if ($isAlreadyAnswered > 0) {
            $feedback = "Anda sudah menjawab tantangan hari ini. Coba tantangan berikutnya.";
            $showModal = false; // Tidak menampilkan modal
        } else {
            // Validasi jawaban
            $query = "SELECT jawaban_benar FROM daily_coding WHERE kode_soal = :kode_soal";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':kode_soal', $kode_soal);
            $stmt->execute();
            $jawaban_benar = $stmt->fetchColumn();

            if ($jawaban_user === $jawaban_benar) {
                $feedback = "Jawaban Anda benar! Anda mendapatkan 1 Api.";
                $showModal = true;
                $status = 'completed'; // Set status ke 'completed'

                // Simpan poin ke database
                $sql = "INSERT INTO progres_api (id_user, id_daily_coding, api_diperoleh, tanggal_perolehan, status)
                        VALUES (:id_user, :id_daily_coding, 1, CURDATE(), :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $stmt->bindParam(':id_daily_coding', $kode_soal, PDO::PARAM_STR);
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->execute();

                // Tambahkan poin ke API poin total
                $apiPoints++;

                // Perbarui ke tab berikutnya
                $activeTab = $activeTab + 1;
                if ($activeTab > 7) {
                    $activeTab = 7; // Pastikan tidak lebih dari hari ke-7
                }
            } else {
                $feedback = "Jawaban Anda salah. Coba lagi.";
                $status = 'failed'; // Set status ke 'failed'

                // Simpan status 'failed' di database
                $sql = "INSERT INTO progres_api (id_user, id_daily_coding, api_diperoleh, tanggal_perolehan, status)
                        VALUES (:id_user, :id_daily_coding, 0, CURDATE(), :status)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $stmt->bindParam(':id_daily_coding', $kode_soal, PDO::PARAM_STR);
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tantangan Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }

        .content {
            margin-top: 150px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        input[type="radio"],
        label {
            color: black;
        }

        .soal-harian {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="content container">
        <h1 class="text-center my-4">Tantangan Harian</h1>

        <!-- Reward Header -->
        <div class="text-center mb-4">
            <a href="tukar-api.php" class="btn btn-danger">Tukar Api</a>
            <span class="fs-4 fw-bold text-white"><?= $apiPoints; ?></span>
        </div>

        <!-- Nav Pills -->
        <ul class="nav nav-pills justify-content-center mb-4">
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $i === $activeTab ? 'active' : '' ?>" href="#day<?= $i ?>" data-bs-toggle="tab">Hari <?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <?php $day = 1; ?>
            <?php foreach ($questions as $row): ?>
                <div class="tab-pane fade <?= $day === $activeTab ? 'show active' : '' ?>" id="day<?= $day ?>">
                    <div class="card mb-4">
                        <h3 class="soal-harian">Soal Hari Ke-<?= $day ?></h3>
                        <pre class="bg-light p-3 rounded text-dark"><?= htmlspecialchars($row['deskripsi_tantangan']) ?></pre>
                        <form method="POST" action="">
                            <input type="hidden" name="kode_soal" value="<?= $row['kode_soal'] ?>">
                            <input type="hidden" name="day" value="<?= $day ?>">

                            <div class="mb-2">
                                <input type="radio" id="answerA_<?= $day ?>" name="jawaban" value="A" required>
                                <label for="answerA_<?= $day ?>"><?= htmlspecialchars($row['opsi_a']) ?></label>
                            </div>
                            <div class="mb-2">
                                <input type="radio" id="answerB_<?= $day ?>" name="jawaban" value="B">
                                <label for="answerB_<?= $day ?>"><?= htmlspecialchars($row['opsi_b']) ?></label>
                            </div>
                            <div class="mb-2">
                                <input type="radio" id="answerC_<?= $day ?>" name="jawaban" value="C">
                                <label for="answerC_<?= $day ?>"><?= htmlspecialchars($row['opsi_c']) ?></label>
                            </div>
                            <div class="mb-2">
                                <input type="radio" id="answerD_<?= $day ?>" name="jawaban" value="D">
                                <label for="answerD_<?= $day ?>"><?= htmlspecialchars($row['opsi_d']) ?></label>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Kirim Jawaban</button>
                        </form>
                        <?php if ($day === $activeTab): ?>
                            <div class="mt-3 text-<?= $showModal ? 'success' : 'danger' ?>"><?= $feedback; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $day++; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <?php if ($showModal): ?>
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <h2 class="text-warning fw-bold">Selamat!</h2>
                        <img src="https://img.icons8.com/emoji/48/fire.png" alt="Fire" width="60" class="fire-icon mt-4 gap-5">
                        <p class="text-dark fs-4">Anda telah menyelesaikan tantangan hari ini!</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" data-bs-dismiss="modal">Lanjut</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require 'footer.php'; ?>
</body>

</html>