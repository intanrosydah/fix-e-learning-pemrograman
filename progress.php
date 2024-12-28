<?php
session_start();
require 'config.php';
require 'header-login.php';

$user_id = $_SESSION['user_id']; // Ambil ID user dari session

// Query untuk mengambil data progres kelas yang sedang dipelajari
$queryDipilih = "
    SELECT k.nama_kelas 
    FROM progres_kelas pk
    JOIN kelas k ON pk.id_kelas = k.id_kelas
    WHERE pk.id = :user_id AND pk.status = 'dipilih'
";

// Query untuk mengambil data progres kelas yang telah diselesaikan
$queryDiselesaikan = "
    SELECT k.nama_kelas 
    FROM progres_kelas pk
    JOIN kelas k ON pk.id_kelas = k.id_kelas
    WHERE pk.id = :user_id AND pk.status = 'diselesaikan'
";

try {
    $stmtDipilih = $pdo->prepare($queryDipilih);
    $stmtDipilih->execute([':user_id' => $user_id]);
    $kelasDipilih = $stmtDipilih->fetchAll(PDO::FETCH_ASSOC);

    $stmtDiselesaikan = $pdo->prepare($queryDiselesaikan);
    $stmtDiselesaikan->execute([':user_id' => $user_id]);
    $kelasDiselesaikan = $stmtDiselesaikan->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Kelas</title>
    <style>
    body {
        margin: 0;
        font-family: "Montserrat", sans-serif;
        background-color: #092635;
    }

    .progress-container {
        display: flex;
        justify-content: space-around;
        padding: 20px;
        margin-top: 80px; /* Tambahkan jarak dari atas */
    }

    section {
        width: 45%;
        background-color: #092635;
        padding: 20px;
        border-radius: 8px;
    }

    h2 {
        text-align: center;
        color:#FFFFFF;
    }
    

    .kelas-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FFFFFF;
        padding: 10px;
        margin: 10px 0;
        border-radius: 6px;
    }

    .kelas-card p {
        margin: 0;
    }

    button {
        background-color: #092635;
        color: #FFFFFF;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
    }

    button:hover {
        background-color:grey;
        color: #000000;
    }
</style>

</head>
<body>

<main class="progress-container">
    <section class="kelas-dipilih">
        <h2>Kelas yang Dipelajari</h2>
        <?php if (!empty($kelasDipilih)): ?>
            <?php foreach ($kelasDipilih as $kelas): ?>
                <div class="kelas-card">
                    <p><?php echo htmlspecialchars($kelas['nama_kelas']); ?></p>
                    <button>Koridor Kelas</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
          <div class="kelas-card">
            <p>Tidak ada kelas yang sedang dipelajari.</p>
            </div>
        <?php endif; ?>
    </section>

    <section class="kelas-selesai">
        <h2>Kelas yang Diselesaikan</h2>
        <?php if (!empty($kelasDiselesaikan)): ?>
            <?php foreach ($kelasDiselesaikan as $kelas): ?>
                <div class="kelas-card">
                    <p><?php echo htmlspecialchars($kelas['nama_kelas']); ?></p>
                    <button>Koridor Kelas</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
          <div class="kelas-card">
            <p>Belum ada kelas yang diselesaikan.</p>
            </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
