<?php
// Koneksi ke database
require 'config.php';

// Pastikan ada file yang di-upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['logo_metode_pembayaran']) && $_FILES['logo_metode_pembayaran']['error'] == 0) {
    $nama_metode_pembayaran = $_POST['nama_metode_pembayaran'];  // Ambil nama metode pembayaran
    $file_tmp = $_FILES['logo_metode_pembayaran']['tmp_name']; // Ambil file yang di-upload

    // Validasi file gambar (opsional)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($file_tmp);
    if (!in_array($file_type, $allowed_types)) {
        die('Hanya file gambar yang diperbolehkan.');
    }

    // Ambil isi gambar (file) ke dalam format biner
    $logo_metode_pembayaran = file_get_contents($file_tmp);

    // Persiapkan query untuk memasukkan data ke tabel metode_pembayaran
    $query = "INSERT INTO metode_pembayaran (nama_metode_pembayaran, logo_metode_pembayaran) VALUES (:nama_metode_pembayaran, :logo_metode_pembayaran)";
    $stmt = $pdo->prepare($query);

    // Bind parameter dan eksekusi query
    $stmt->bindParam(':nama_metode_pembayaran', $nama_metode_pembayaran, PDO::PARAM_STR);
    $stmt->bindParam(':logo_metode_pembayaran', $logo_metode_pembayaran, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        echo "Logo metode pembayaran berhasil di-upload.";
    } else {
        echo "Terjadi kesalahan saat meng-upload gambar.";
    }
} else {
    echo "Tidak ada file yang di-upload atau terjadi kesalahan.";
}
?>

<!-- Form untuk upload gambar -->
<form action="" method="POST" enctype="multipart/form-data">
    <label for="nama_metode_pembayaran">Nama Metode Pembayaran:</label>
    <input type="text" id="nama_metode_pembayaran" name="nama_metode_pembayaran" required>

    <label for="logo_metode_pembayaran">Logo Metode Pembayaran:</label>
    <input type="file" id="logo_metode_pembayaran" name="logo_metode_pembayaran" accept="image/*" required>

    <button type="submit">Upload</button>
</form>