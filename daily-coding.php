<?php
require 'header-login.php'; // Memasukkan header
require 'config.php'; // File koneksi database

// Query untuk mengambil data dari daily_coding
$query = "SELECT * FROM daily_coding";
$stmt = $pdo->prepare($query);
$stmt->execute();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_user = $_POST['id_user'];
        $kode_soal = $_POST['kode_soal'];
        $jawaban_user = $_POST['jawaban_user'];

        // Ambil jawaban yang benar berdasarkan kode soal dari database
        $query = "SELECT jawaban_benar FROM daily_coding WHERE kode_soal = :kode_soal";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':kode_soal', $kode_soal);
        $stmt->execute();
        $jawaban_benar = $stmt->fetchColumn();

        // Validasi jawaban user
        if (trim($jawaban_benar) === trim($jawaban_user)) {
            $status_tantangan = 'selesai';
            $poin_didapatkan = 1; // Poin API untuk jawaban benar
        } else {
            $status_tantangan = 'belum';
            $poin_didapatkan = 0;
        }

        // Tambah atau update data di tabel `user_daily_coding`
        $sql = "INSERT INTO user_daily_coding (id_user, hari_tantangan, kode_soal, jawaban_user, status_tantangan, perolehan_api)
                VALUES (:id_user, CURDATE(), :kode_soal, :jawaban_user, :status_tantangan, :perolehan_api)
                ON DUPLICATE KEY UPDATE 
                    status_tantangan = :status_tantangan, 
                    perolehan_api = perolehan_api + :perolehan_api";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':kode_soal', $kode_soal);
        $stmt->bindParam(':jawaban_user', $jawaban_user);
        $stmt->bindParam(':status_tantangan', $status_tantangan);
        $stmt->bindParam(':perolehan_api', $poin_didapatkan);
        $stmt->execute();

        $message = "Jawaban berhasil disimpan!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }

    // Return response as JSON
    echo json_encode([
        'success' => $status_tantangan === 'selesai',
        'apiPoints' => $poin_didapatkan,
        'message' => $message,
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tantangan Harian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }
        .content { margin-top: 150px; }
        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .soal-harian {
            color: #007bff; /* Warna biru untuk soal */
        }
        .reward-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            background-color: rgba(9, 38, 53, 0.7);
            border-radius: 8px;
        }

        .feedback {
            margin-top: 10px;
            font-weight: bold;
        }

        .feedback.correct {
            color: green;
        }

        .feedback.incorrect {
            color: red;
        }

        #daily-coding-section {
            display: none; /* Sembunyikan tantangan harian pada awalnya */
        }

        #intro-section {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="content container">
    <!-- Intro Section -->
    <div id="intro-section">
        <h1>Apa Itu Daily Coding?</h1>
        <p>Daily Coding adalah rutinitas latihan pemrograman harian yang bertujuan untuk meningkatkan keterampilan coding dan pemecahan masalah. Melalui daily coding, seseorang mengasah kemampuan logika, memahami konsep-konsep pemrograman baru, serta memperkuat pemahaman algoritma dan struktur data. Biasanya, kegiatan ini melibatkan penyelesaian soal-soal dengan tingkat kesulitan yang bervariasi setiap hari, baik dalam bahasa pemrograman tertentu maupun dalam bahasa yang berbeda. Dengan konsistensi, daily coding membantu pengembangan keahlian teknis dan meningkatkan efisiensi dalam menulis kode.</p>
        
        <h2>Bagaimana Cara Kerja Daily Coding?</h2>
        <ol style="list-style-type: none;">
            <li>Klik tombol mulai</li>
            <li>Selesaikan tantangan harian, setiap menyelesaikan tantangan dapat 1 api</li>
            <li>Kumpulkan api untuk ditukarkan Paket Kursus Online</li>
        </ol>
        <button id="start-button" class="btn btn-primary">Mulai</button>
    </div>

    <!-- Daily Coding Challenges Section -->
    <div id="daily-coding-section">
        <h1 class="text-center my-4">Tantangan Harian</h1>

        <!-- Reward Header -->
        <div class="reward-header text-center my-4">
            <a href="tukar-api.php" class="btn btn-danger">Tukar Api</a>
            <span id="api-points" class="fs-4 fw-bold text-white">0</span> <!-- Poin Api -->
        </div>

        <!-- Nav Pills -->
        <ul class="nav nav-pills justify-content-center mb-4" id="challenge-tabs">
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $i === 1 ? 'active' : '' ?>" id="day<?= $i ?>-tab" data-bs-toggle="pill" href="#day<?= $i ?>">Hari <?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>

<!-- Tab Content -->
<div class="tab-content">
    <?php $day = 1; ?>
    <?php foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row): ?>
        <div class="tab-pane fade <?= $day === 1 ? 'show active' : '' ?>" id="day<?= $day ?>" role="tabpanel">
            <div class="card mb-4 question-box md-grid gap-2 d-md-block">
                <h3 class="soal-harian">Soal Hari Ke-<?= $day ?></h3>
                <pre class="bg-light p-3 rounded text-dark"><?= htmlspecialchars($row['deskripsi_tantangan']) ?></pre>
                <div class="question-option text-dark">
                    <input type="radio" id="answer1_<?= $day ?>" name="answer[<?= $day ?>]" value="A" required>
                    <label for="answer1_<?= $day ?>"><?= htmlspecialchars($row['opsi_a']); ?></label>
                </div>
                <div class="question-option text-dark">
                    <input type="radio" id="answer2_<?= $day ?>" name="answer[<?= $day ?>]" value="B">
                    <label for="answer2_<?= $day ?>"><?= htmlspecialchars($row['opsi_b']); ?></label>
                </div>
                <div class="question-option text-dark">
                    <input type="radio" id="answer3_<?= $day ?>" name="answer[<?= $day ?>]" value="C">
                    <label for="answer3_<?= $day ?>"><?= htmlspecialchars($row['opsi_c']); ?></label>
                </div>
                <div class="question-option text-dark">
                    <input type="radio" id="answer4_<?= $day ?>" name="answer[<?= $day ?>]" value="D">
                    <label for="answer4_<?= $day ?>"><?= htmlspecialchars($row['opsi_d']); ?></label>
                </div>
                <div class="submit-button mt-4">
                    <button type="button" class="btn btn-primary" onclick="checkAnswer(<?= $day ?>)">Kirim Jawaban</button>
                    <div id="feedback-<?= $day ?>" class="feedback"></div>
                </div>
            </div>
        </div>
        <?php $day++; ?>
    <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-body">
                <h2 class="text-warning fw-bold">Selamat!</h2>
                <img src="https://img.icons8.com/emoji/48/fire.png" alt="Fire" width="60" class="fire-icon mt-4 gap-5">
                <p class="text-center text-dark fs-3">Anda telah menyelesaikan tantangan hari ini!</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="nextChallenge()">Lanjut</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- JavaScript -->
<script>
    let apiPoints = 0; // Inisialisasi Poin Api

    // Tampilkan bagian Daily Coding setelah tombol mulai diklik
    document.getElementById('start-button').addEventListener('click', function () {
        document.getElementById('intro-section').style.display = 'none';
        document.getElementById('daily-coding-section').style.display = 'block';
    });

    function checkAnswer(day) {
    const userAnswer = document.querySelector(`input[name="answer[${day}]"]:checked`)?.value;
    const feedback = document.getElementById(`feedback-${day}`);
    const kodeSoal = `${String(day).padStart(2, '0')}A`; // Format day as two digits and append 'A'
    const idUser = 1; // Example user ID

    // Pastikan jawaban dipilih
    if (!userAnswer) {
        feedback.textContent = "Pilih jawaban terlebih dahulu!";
        feedback.className = "feedback incorrect";
        return;
    }

    fetch('daily-coding.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            id_user: idUser,
            kode_soal: kodeSoal,
            jawaban_user: userAnswer,
        }),
    })

        if (userCode === solutions[day].trim()) {
            feedback.textContent = "Kode Anda Benar!";
            feedback.className = "feedback correct";
            apiPoints++; // Tambahkan Poin Api
            document.getElementById('api-points').textContent = apiPoints; // Perbarui tampilan poin

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
        } else {
            feedback.textContent = "Kode Anda Salah. Coba Lagi!";
            feedback.className = "feedback incorrect";
        }
    }

    document.getElementById('start-button').addEventListener('click', () => {
        document.getElementById('intro-section').style.display = 'none';
        document.getElementById('daily-coding-section').style.display = 'block';
    });

    function nextChallenge() {
        const activeTab = document.querySelector('.nav-pills .nav-link.active');
        const nextTab = activeTab.parentElement.nextElementSibling?.querySelector('.nav-link');
        if (nextTab) {
            nextTab.click();
        }
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
