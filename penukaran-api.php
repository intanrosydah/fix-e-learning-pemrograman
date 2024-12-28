<?php
include 'header-login.php'; // Menyertakan header
require 'config.php'; // Menyertakan konfigurasi database

$message = '';

// Ambil data untuk dropdown paket
$paketOptions = [];
try {
    $query = "SELECT id_paket_api, nama_paket_api, api_minimal FROM paket_api";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $paketOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}

// Ambil data untuk username (hanya digunakan untuk validasi)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $query = "SELECT id FROM user WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $userId = $stmt->fetchColumn();

    if (!$userId) {
        $message = "Username tidak ditemukan!";
    }
}

// Menangani form pengisian data penukaran API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_paket_api'])) {
    $idPaketApi = $_POST['id_paket_api'];
    $apiMinimal = $_POST['api_minimal'];
    $waktuPenukaran = date('Y-m-d H:i:s');
    $apiDitukarkan = $apiMinimal; // Sesuai dengan API minimal

    try {
        // Query untuk memasukkan data penukaran API
        $query = "INSERT INTO tukar_api (id_user, id_paket_api, api_ditukarkan, waktu_penukaran, status_penukaran) 
                  VALUES (:id_user, :id_paket_api, :api_ditukarkan, :waktu_penukaran, 'Pending')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_paket_api', $idPaketApi, PDO::PARAM_INT);
        $stmt->bindParam(':api_ditukarkan', $apiDitukarkan, PDO::PARAM_INT);
        $stmt->bindParam(':waktu_penukaran', $waktuPenukaran, PDO::PARAM_STR);
        $stmt->execute();

        $message = "Penukaran API berhasil dilakukan!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Penukaran API</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>

<body>
    <section class="vh-100 mt-5">
        <div class="container py-5 h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
                            <p class="lead fw-normal text-center me-3">Form Penukaran API</p>
                        </div>

                        <?php if ($message): ?>
                            <div class="alert alert-info">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Username -->
                        <div class="form-outline mb-4">
                            <input type="text" id="formUsername" class="form-control form-control-lg" name="username" placeholder="Masukkan Username" required />
                            <label class="form-label" for="formUsername">Username</label>
                        </div>

                        <!-- Pilih Paket API -->
                        <div class="form-outline mb-4">
                            <select id="id_paket_api" class="form-select form-control-lg" name="id_paket_api" onchange="updateApiMinimal()" required>
                                <option value="" disabled selected>Pilih Paket API</option>
                                <?php foreach ($paketOptions as $paket): ?>
                                    <option value="<?= $paket['id_paket_api'] ?>"
                                        data-api-minimal="<?= $paket['api_minimal'] ?>">
                                        <?= htmlspecialchars($paket['nama_paket_api']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label class="form-label" for="id_paket_api">Pilih Paket API</label>
                        </div>

                        <!-- API Minimal -->
                        <div class="form-outline mb-4">
                            <input type="number" id="api_minimal" class="form-control form-control-lg" name="api_minimal" readonly />
                            <label class="form-label" for="api_minimal">API Minimal</label>
                        </div>

                        <!-- Waktu Penukaran -->
                        <div class="form-outline mb-4">
                            <input type="text" id="waktu_penukaran" class="form-control form-control-lg" value="<?= date('Y-m-d H:i:s') ?>" readonly />
                            <label class="form-label" for="waktu_penukaran">Waktu Penukaran</label>
                        </div>

                        <!-- API Ditukarkan -->
                        <div class="form-outline mb-4">
                            <input type="number" id="api_ditukarkan" class="form-control form-control-lg" name="api_ditukarkan" readonly />
                            <label class="form-label" for="api_ditukarkan">API Ditukarkan</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem">
                                Tukar API
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Update API minimal berdasarkan paket yang dipilih
        function updateApiMinimal() {
            var selectedOption = document.getElementById("id_paket_api").selectedOptions[0];
            var apiMinimal = selectedOption.getAttribute("data-api-minimal");
            document.getElementById("api_minimal").value = apiMinimal;
            document.getElementById("api_ditukarkan").value = apiMinimal;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>