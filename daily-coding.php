<?php
require 'header-login.php'; // Memasukkan header
require 'config.php'; // File koneksi database

// Jawaban benar untuk setiap soal
$solutions = [
    "n = int(input('Masukkan angka: '))\nfaktorial = 1\nfor i in range(1, n + 1):\n    faktorial *= i\nprint(f'Faktorial dari {n} adalah {faktorial}')",
    "n = int(input('Masukkan angka: '))\nprima = True\nfor i in range(2, int(n / 2) + 1):\n    if n % i == 0:\n        prima = False\n        break\nif prima:\n    print(f'{n} adalah bilangan prima.')\nelse:\n    print(f'{n} bukan bilangan prima.')",
    "n = int(input('Masukkan angka n: '))\na, b = 0, 1\nfor i in range(n):\n    print(a, end=' ')\n    a, b = b, a + b",
    "daftar = [1, 3, 5, 7, 9]\nprint('Angka terbesar:', max(daftar))",
    "daftar = [5, 2, 9, 1, 5, 6]\ndaftar.sort()\nprint('Daftar angka yang diurutkan:', daftar)",
    "n = int(input('Masukkan angka: '))\nif n % 2 == 0:\n    print(f'{n} adalah angka genap.')\nelse:\n    print(f'{n} adalah angka ganjil.')",
    "daftar = [1, 2, 3, 4, 5]\nrata_rata = sum(daftar) / len(daftar)\nprint('Rata-rata angka:', rata_rata)"
];

// Variabel pesan
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_user = $_POST['id_user'];
        $kode_soal = $_POST['kode_soal'];
        $jawaban_user = $_POST['jawaban_user'];

        // Ambil jawaban yang benar berdasarkan kode soal
        $index_soal = intval(substr($kode_soal, -1)) - 1; // Misal, "soal1" jadi 0
        $jawaban_benar = $solutions[$index_soal];

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
        'success' => $status_tantangan === 'selesa',
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
        <ol>
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
        <div class="reward-header mx-auto mb-4">
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
            <?php 
            $questions = [
                "Buat program untuk menghitung faktorial dari sebuah angka yang dimasukkan oleh pengguna.",
                "Buat program untuk menentukan apakah sebuah angka adalah bilangan prima atau bukan.",
                "Buat program untuk menampilkan angka Fibonacci ke-n yang dimasukkan oleh pengguna.",
                "Buat program untuk menghitung angka terbesar dalam sebuah daftar.",
                "Buat program untuk mengurutkan daftar angka.",
                "Buat program untuk menentukan angka ganjil atau genap.",
                "Buat program untuk mencari nilai rata-rata dari sebuah daftar angka."
            ];

            $solutions = [
                "n = int(input('Masukkan angka: '))\nfaktorial = 1\nfor i in range(1, n + 1):\n    faktorial *= i\nprint(f'Faktorial dari {n} adalah {faktorial}')",
                "n = int(input('Masukkan angka: '))\nprima = True\nfor i in range(2, int(n / 2) + 1):\n    if n % i == 0:\n        prima = False\n        break\nif prima:\n    print(f'{n} adalah bilangan prima.')\nelse:\n    print(f'{n} bukan bilangan prima.')",
                "n = int(input('Masukkan angka n: '))\na, b = 0, 1\nfor i in range(n):\n    print(a, end=' ')\n    a, b = b, a + b",
                "daftar = [1, 3, 5, 7, 9]\nprint('Angka terbesar:', max(daftar))",
                "daftar = [5, 2, 9, 1, 5, 6]\ndaftar.sort()\nprint('Daftar angka yang diurutkan:', daftar)",
                "n = int(input('Masukkan angka: '))\nif n % 2 == 0:\n    print(f'{n} adalah angka genap.')\nelse:\n    print(f'{n} adalah angka ganjil.')",
                "daftar = [1, 2, 3, 4, 5]\nrata_rata = sum(daftar) / len(daftar)\nprint('Rata-rata angka:', rata-rata)"
            ];

            foreach ($questions as $index => $question): 
            ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="day<?= $index + 1 ?>">
                    <div class="card md-grid gap-2 d-md-block">
                        <h3 class="soal-harian">Soal Hari Ke-<?= $index + 1 ?></h3>
                        <p class="fw-bold soal-harian"><?= $question ?></p>
                        <textarea id="user-code-<?= $index ?>" class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px"></textarea>
                        <button type="button" class="btn btn-dark" onclick="checkAnswer(<?= $index ?>)">Kirim Kode</button>
                        <div id="feedback-<?= $index ?>" class="feedback"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    const solutions = <?= json_encode($solutions) ?>;
    let apiPoints = 0; // Inisialisasi Poin Api

    // Tampilkan bagian Daily Coding setelah tombol mulai diklik
    document.getElementById('start-button').addEventListener('click', function () {
        document.getElementById('intro-section').style.display = 'none';
        document.getElementById('daily-coding-section').style.display = 'block';
    });

    function checkAnswer(index) {
        const userCode = document.getElementById(`user-code-${index}`).value.trim();
        const feedback = document.getElementById(`feedback-${index}`);
        const kodeSoal = `soal${index + 1}`;
        const idUser = 1;

        fetch('daily-coding.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                id_user: idUser,
                kode_soal: kodeSoal,
                jawaban_user: userCode,
            }),
        })
        
        if (userCode === solutions[index].trim()) {
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