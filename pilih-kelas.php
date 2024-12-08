<?php
session_start();
include 'config.php';



// Ambil data user dari session
$user_id = $_SESSION['user_id'];

// Query data user berdasarkan session
$query_user = "SELECT * FROM user WHERE id = :id";
$stmt_user = $pdo->prepare($query_user);
$stmt_user->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Data user tidak ditemukan!";
    exit();
}

// Query data kelas (optional: filter jika perlu)
$query_kelas = "SELECT * FROM kelas"; // Jika ingin filter user: tambahkan WHERE user_id = :user_id
$stmt_kelas = $pdo->prepare($query_kelas);
$stmt_kelas->execute();
$kelas_list = $stmt_kelas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1>Halo, <?= htmlspecialchars($user['name']); ?>!</h1>
    <p>Berikut adalah daftar kelas:</p>

    <div class="row">
        <?php foreach ($kelas_list as $kelas): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($kelas['nama_kelas']); ?></h5>
                        <p class="card-text">Deskripsi: <?= htmlspecialchars($kelas['deskripsi']); ?></p>
                        <a href="detail-kelas.php?id=<?= $kelas['id_kelas']; ?>" class="btn btn-primary">Pilih Kelas</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
