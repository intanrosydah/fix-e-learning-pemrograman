<?php
session_start(); // Pastikan sesi dimulai untuk mengambil data user login
require 'config.php'; // File koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit();
}

$id_user = $_SESSION['user_id']; // Ambil ID pengguna dari sesi

// Ambil data paket dari database
$paketQuery = "SELECT * FROM paket";
$paketStmt = $pdo->query($paketQuery);
$paketData = $paketStmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data metode pembayaran dari database
$metodeQuery = "SELECT * FROM metode_pembayaran";
$metodeStmt = $pdo->query($metodeQuery);
$metodeData = $metodeStmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty($_POST['id_paket']) || empty($_POST['id_metode_pembayaran']) || empty($_FILES['bukti_pembayaran']['name'])) {
        die('All fields are required!');
    }

    $id_paket = $_POST['id_paket'];
    $id_metode_pembayaran = $_POST['id_metode_pembayaran'];

    // Handle file upload for payment proof
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        // Validate image file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
        $file_type = mime_content_type($file_tmp);

        if (!in_array($file_type, $allowed_types)) {
            die("Only image files are allowed for payment proof.");
        }

        // Read the image file into binary format
        $bukti_pembayaran = file_get_contents($file_tmp);

        // Insert payment data into the database
        $insertQuery = "INSERT INTO langganan (id, id_paket, id_metode_pembayaran, bukti_pembayaran, tanggal_mulai, tanggal_selesai) 
                        VALUES (:id_user, :id_paket, :id_metode_pembayaran, :bukti_pembayaran, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH))";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_paket', $id_paket, PDO::PARAM_INT);
        $stmt->bindParam(':id_metode_pembayaran', $id_metode_pembayaran, PDO::PARAM_INT);
        $stmt->bindParam(':bukti_pembayaran', $bukti_pembayaran, PDO::PARAM_LOB); // Store binary data

        if ($stmt->execute()) {
            // Retrieve the last inserted ID
            $id_langganan = $pdo->lastInsertId();
            // Redirect to the class selection page with the langganan ID as a query parameter
            header("Location: pilih-kelas.php?id_langganan=" . $id_langganan);
            exit;
        } else {
            die('Failed to save subscription data.');
        }
    } else {
        die('Error uploading the payment proof file.');
    }
}

// Script untuk mengembalikan nomor virtual account
if (isset($_GET['id_metode_pembayaran'])) {
    $id_metode_pembayaran = $_GET['id_metode_pembayaran'];

    // Ambil no_va berdasarkan id_metode_pembayaran
    $query = "SELECT no_va FROM metode_pembayaran WHERE id_metode_pembayaran = :id_metode_pembayaran";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_metode_pembayaran', $id_metode_pembayaran, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'virtual_account' => $result['no_va']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Virtual Account tidak ditemukan']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Montserrat, sans-serif;
            background-color: #092635;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        select,
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #092635;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: gray;
        }

        .va-container {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <script>
        function showVirtualAccount() {
            const metodePembayaran = document.getElementById('id_metode_pembayaran');
            const vaContainer = document.getElementById('va-container');

            metodePembayaran.addEventListener('change', () => {
                const idMetode = metodePembayaran.value;
                if (idMetode) {
                    fetch(`?id_metode_pembayaran=${idMetode}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                vaContainer.innerHTML = `Virtual Account: <strong>${data.virtual_account}</strong>`;
                            } else {
                                vaContainer.innerHTML = 'Virtual Account tidak tersedia.';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            vaContainer.innerHTML = 'Terjadi kesalahan saat mengambil data.';
                        });
                } else {
                    vaContainer.innerHTML = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', showVirtualAccount);
    </script>
</head>

<body>
    <div class="container">
        <h1>Halaman Pembayaran</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="id_paket">Pilih Paket:</label>
            <select name="id_paket" id="id_paket" required>
                <option value="">-- Pilih Paket --</option>
                <?php foreach ($paketData as $paket): ?>
                    <option value="<?= $paket['id_paket'] ?>">
                        <?= htmlspecialchars($paket['nama_paket']) ?> - Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_metode_pembayaran">Pilih Metode Pembayaran:</label>
            <select name="id_metode_pembayaran" id="id_metode_pembayaran" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <?php foreach ($metodeData as $metode): ?>
                    <option value="<?= $metode['id_metode_pembayaran'] ?>">
                        <?= htmlspecialchars($metode['nama_metode_pembayaran']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div id="va-container" class="va-container"></div>

            <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required>

            <button type="submit">Konfirmasi Pembayaran</button>
        </form>
    </div>
</body>

</html>