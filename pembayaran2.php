<?php
include 'header-login.php';
require 'config.php';

$message = '';

// Ambil data untuk dropdown paket
$paketOptions = [];
try {
    $query = "SELECT id_paket, nama_paket FROM paket";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $paketOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}

// Ambil data untuk dropdown metode pembayaran
$metodeOptions = [];
try {
    $query = "SELECT id_metode_pembayaran, nama_metode_pembayaran, id_nomor_va FROM metode_pembayaran";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $metodeOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}

$selectedNomorVA = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_metode_pembayaran'])) {
    $idMetodePembayaran = $_POST['id_metode_pembayaran'];

    // Ambil nomor VA dari metode pembayaran yang dipilih
    $query = "SELECT nomor_va FROM nomor_va WHERE id_nomor_va = 
              (SELECT id_nomor_va FROM metode_pembayaran WHERE id_metode_pembayaran = :id_metode_pembayaran)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_metode_pembayaran', $idMetodePembayaran, PDO::PARAM_INT);
    $stmt->execute();
    $selectedNomorVA = $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil data dari form
        $username = $_POST['username'];
        $id_paket = $_POST['id_paket'];
        $id_metode_pembayaran = $_POST['id_metode_pembayaran'];

        // Validasi username dan dapatkan id_user
        $query = "SELECT id FROM user WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $id_user = $stmt->fetchColumn();

        if (!$id_user) {
            $message = "Username tidak ditemukan!";
        } else {
            // Menangani upload file bukti pembayaran
            if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
                // Validasi file gambar
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
                $file_type = mime_content_type($file_tmp);
                if (!in_array($file_type, $allowed_types)) {
                    $message = "Hanya file gambar yang diperbolehkan untuk bukti pembayaran.";
                } else {
                    // Ambil isi gambar (file) ke dalam format biner
                    $bukti_pembayaran = file_get_contents($file_tmp);

                    // Lanjutkan dengan query untuk menyimpan data pembayaran
                    $sql = "INSERT INTO langganan (id, id_paket, id_metode_pembayaran, tanggal_mulai, tanggal_selesai, bukti_pembayaran) 
                            VALUES (:id_user, :id_paket, :id_metode_pembayaran, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), :bukti_pembayaran)";
                    $stmt = $pdo->prepare($sql);

                    // Bind parameter
                    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $stmt->bindParam(':id_paket', $id_paket, PDO::PARAM_INT);
                    $stmt->bindParam(':id_metode_pembayaran', $id_metode_pembayaran, PDO::PARAM_INT);
                    $stmt->bindParam(':bukti_pembayaran', $bukti_pembayaran, PDO::PARAM_LOB);

                    // Eksekusi query
                    $stmt->execute();
                    $message = "Pembayaran berhasil disimpan!";
                }
            } else {
                $message = "Tidak ada file yang di-upload atau terjadi kesalahan.";
            }
        }
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
    <title>Form Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }
    </style>
</head>

<body>
    <section class="vh-100 mt-5">
        <div class="container py-5 h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post" enctype="multipart/form-data">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
                            <p class="lead fw-normal text-center me-3">FORM PEMBAYARAN</p>
                        </div>

                        <?php if ($message): ?>
                            <div class="alert alert-info">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Username -->
                        <div class="form-outline mb-4">
                            <input type="text" id="formUsername" class="form-control form-control-lg" name="username"
                                placeholder="Masukkan Username" required />
                            <label class="form-label" for="formUsername">Username</label>
                        </div>

                        <!-- Pilih Paket -->
                        <div class="form-outline mb-4">
                            <select id="formIdPaket" class="form-select form-control-lg" name="id_paket" required>
                                <option value="" disabled selected>Pilih Paket</option>
                                <?php foreach ($paketOptions as $paket): ?>
                                    <option value="<?= $paket['id_paket'] ?>"><?= htmlspecialchars($paket['nama_paket']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="form-label" for="formIdPaket">Paket</label>
                        </div>

                        <!-- Pilih Metode Pembayaran -->
                        <div class="form-outline mb-4">
                            <select id="formIdMetode" class="form-select form-control-lg" name="id_metode_pembayaran" onchange="this.form.submit()" required>
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                <?php foreach ($metodeOptions as $metode): ?>
                                    <option value="<?= $metode['id_metode_pembayaran'] ?>" <?= isset($_POST['id_metode_pembayaran']) && $_POST['id_metode_pembayaran'] == $metode['id_metode_pembayaran'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($metode['nama_metode_pembayaran']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label class="form-label" for="formIdMetode">Metode Pembayaran</label>
                        </div>

                        <!-- Nomor VA yang terkait dengan metode pembayaran yang dipilih -->
                        <div id="nomorVA" class="form-outline mb-4">
                            <input type="text" id="nomorVaDisplay" class="form-control form-control-lg" readonly
                                value="<?= htmlspecialchars($selectedNomorVA ?: 'Nomor VA akan ditampilkan di sini') ?>">
                            <label class="form-label" for="nomorVaDisplay">Nomor VA</label>
                        </div>

                        <!-- Upload Bukti Pembayaran -->
                        <div class="form-outline mb-4">
                            <input type="file" id="buktiPembayaran" class="form-control form-control-lg" name="bukti_pembayaran" />
                            <label class="form-label" for="buktiPembayaran">Bukti Pembayaran</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem">
                                Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>