<?php
include 'config2.php';

// Ambil id_langganan dan bukti_pembayaran
if (isset($_GET['id'])) {
    $id_langganan = $_GET['id'];

    // Query untuk mengambil gambar
    $sql = "SELECT bukti_pembayaran FROM langganan WHERE id_langganan = :id_langganan";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_langganan' => $id_langganan]);
    $row = $stmt->fetch();

    if ($row) {
        // Menentukan header untuk jenis gambar
        header("Content-Type: image/jpeg");
        echo $row['bukti_pembayaran']; // Menampilkan gambar
    } else {
        echo "Gambar tidak ditemukan.";
    }
}
