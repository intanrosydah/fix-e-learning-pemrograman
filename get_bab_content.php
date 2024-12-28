<?php
require 'config.php'; // File koneksi database

header('Content-Type: application/json');

$id_bab = isset($_GET['id_bab']) ? intval($_GET['id_bab']) : null;

if (!$id_bab) {
    echo json_encode(['success' => false, 'message' => 'ID bab tidak ditemukan.']);
    exit;
}

try {
    $sql = "SELECT konten_bab FROM bab WHERE id_bab = :id_bab";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_bab' => $id_bab]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'content' => $result['konten_bab']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Bab tidak ditemukan.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan pada server: ' . $e->getMessage()]);
}
