<?php
require_once 'config.php'; // Memasukkan koneksi database

// Ambil semua soal dari database
$query = $pdo->query("SELECT * FROM soal_kuis");
$soal_list = $query->fetchAll(PDO::FETCH_ASSOC);

if (!$soal_list) {
    die("Tidak ada soal tersedia!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Kuis Modul 1</title>
    <style>
        body {
            background-color: #092635;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            color: #000;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #092635;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .header a {
            text-decoration: none;
            color: white;
            font-size: 24px;
        }

        .question-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #092635;
            padding: 20px;
        }

        .question-box {
            background-color: white;
            padding: 40px;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .question-box h3 {
            color: #333;
        }

        .question-option {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .question-option input {
            margin-right: 10px;
        }

        .submit-button {
            text-align: center;
        }

        .submit-button button {
            padding: 7px 40px;
            font-size: 14px;
            background-color: #2a3a5b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="modul-kuis.php">Modul 1</a>
    </div>

    <div class="question-section">
        <form action="skor.php" method="POST">
            <?php foreach ($soal_list as $soal): ?>
            <div class="question-box">
                <h3><?= htmlspecialchars($soal['pertanyaan']); ?></h3>
                <div class="question-option">
                    <input type="radio" id="answer1_<?= $soal['id_soal']; ?>" name="answer[<?= $soal['id_soal']; ?>]" value="A" required>
                    <label for="answer1_<?= $soal['id_soal']; ?>"><?= htmlspecialchars($soal['opsi_a']); ?></label>
                </div>
                <div class="question-option">
                    <input type="radio" id="answer2_<?= $soal['id_soal']; ?>" name="answer[<?= $soal['id_soal']; ?>]" value="B">
                    <label for="answer2_<?= $soal['id_soal']; ?>"><?= htmlspecialchars($soal['opsi_b']); ?></label>
                </div>
                <div class="question-option">
                    <input type="radio" id="answer3_<?= $soal['id_soal']; ?>" name="answer[<?= $soal['id_soal']; ?>]" value="C">
                    <label for="answer3_<?= $soal['id_soal']; ?>"><?= htmlspecialchars($soal['opsi_c']); ?></label>
                </div>
                <div class="question-option">
                    <input type="radio" id="answer4_<?= $soal['id_soal']; ?>" name="answer[<?= $soal['id_soal']; ?>]" value="D">
                    <label for="answer4_<?= $soal['id_soal']; ?>"><?= htmlspecialchars($soal['opsi_d']); ?></label>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="submit-button">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
