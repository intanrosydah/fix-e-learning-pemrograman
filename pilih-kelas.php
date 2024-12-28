<?php
session_start(); // Memulai session
require 'header-login.php'; // Memasukkan header
require 'config.php'; // Konfigurasi database

$query = "SELECT * FROM kelas";
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query gagal: " . $e->getMessage());
}

// Proses pemilihan kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id_kelas']) && isset($_SESSION['user_id'])) {
        $id_kelas = $_POST['id_kelas'];
        $user_id = $_SESSION['user_id']; // Asumsikan user ID disimpan di session

        // Cek apakah kelas sudah ada di keranjang (session)
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        if (count($_SESSION['keranjang']) < 3) {
            // Tambahkan kelas ke dalam keranjang
            if (!in_array($id_kelas, $_SESSION['keranjang'])) {
                $_SESSION['keranjang'][] = $id_kelas;

                // Tambahkan data ke tabel progres_kelas
                try {
                    $insertQuery = "INSERT INTO progres_kelas (id, id_kelas, status, skor_akhir) VALUES (:id, :id_kelas, 'dipilih', 0)";
                    $stmtInsert = $pdo->prepare($insertQuery);
                    $stmtInsert->execute([
                        ':id' => $user_id,
                        ':id_kelas' => $id_kelas,
                    ]);
                    echo "Kelas berhasil ditambahkan ke keranjang dan disimpan dalam database!";
                } catch (PDOException $e) {
                    echo "Gagal menyimpan kelas ke database: " . $e->getMessage();
                }
            } else {
                echo "Kelas ini sudah ada di keranjang.";
            }
        } else {
            echo "Maksimal 3 kelas dapat dipilih.";
        }
    } else {
        echo "Anda harus login untuk memilih kelas.";
    }
}

// Proses untuk menghapus kelas dari keranjang
if (isset($_GET['remove']) && isset($_SESSION['user_id'])) {
    $id_kelas_remove = $_GET['remove'];
    $user_id = $_SESSION['user_id']; // Asumsikan user ID disimpan di session

    if (($key = array_search($id_kelas_remove, $_SESSION['keranjang'])) !== false) {
        unset($_SESSION['keranjang'][$key]);
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // Re-index array

        // Hapus data dari tabel progres_kelas
        try {
            $deleteQuery = "DELETE FROM progres_kelas WHERE id = :id AND id_kelas = :id_kelas AND status = 'dipilih'";
            $stmtDelete = $pdo->prepare($deleteQuery);
            $stmtDelete->execute([
                ':id' => $user_id,
                ':id_kelas' => $id_kelas_remove,
            ]);
            echo "Kelas telah dihapus dari keranjang dan database.";
        } catch (PDOException $e) {
            echo "Gagal menghapus kelas dari database: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas</title>
    <style>
        /* Styling untuk Halaman */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #092635;
            color: #333;
        }

        main {
            padding: 20px;
            margin-top: 80px;
            margin-bottom: 150px;
        }

        .kelas-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .kelas-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 220px;
            text-align: center;
            transition: transform 0.3s;
        }

        .kelas-card:hover {
            transform: translateY(-10px);
        }

        .kelas-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        h3 {
            margin: 10px 0;
            font-size: 1.1em;
        }

        p {
            padding: 0 10px;
            font-size: 0.9em;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 8px 18px;
            margin: 15px 0;
            background-color: #092635;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: rgb(2, 11, 15);
        }

        /* Styling untuk Keranjang */
        .keranjang {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 320px;
            background-color: white;
            color: #333;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid #ddd;
            z-index: 1000;
            font-size: 0.9em;
            max-height: 300px;
            overflow-y: auto;
            cursor: move; /* Menambahkan pointer untuk menunjukkan bahwa ini bisa digeser */
        }

        .keranjang h3 {
            font-size: 1.1em;
            margin-bottom: 12px;
            color: #092635;
        }

        .keranjang ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 10px;
        }

        .keranjang li {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .keranjang .btn {
            background-color: #092635;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.8em;
            transition: background-color 0.3s;
        }

        .keranjang .btn:hover {
            background-color:rgb(2, 11, 15);
        }

        .keranjang .checkout-btn {
            display: block;
            width: 100%;
            background-color: #092635;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .keranjang .checkout-btn:hover {
            background-color: rgb(2, 11, 15);
        }
    </style>
</head>
<body>
<main>
    <section class="kelas-container">
        <?php if (!empty($result)) {
            foreach ($result as $row) { 
                $gambar_kelas = !empty($row['gambar_kelas']) 
                    ? 'data:image/jpeg;base64,' . base64_encode($row['gambar_kelas']) 
                    : 'images/logo-1.png';
                $nama_kelas = $row['nama_kelas'] ?? 'Nama Kelas Tidak Tersedia';
                $deskripsi = $row['deskripsi_kelas'] ?? 'Deskripsi tidak tersedia.';
                $link = $row['link'] ?? '#'; 
        ?>
            <div class="kelas-card">
                <img src="<?php echo htmlspecialchars($gambar_kelas); ?>" alt="<?php echo htmlspecialchars($nama_kelas); ?>" class="kelas-image">
                <h3><?php echo htmlspecialchars($nama_kelas); ?></h3>
                <p><?php echo htmlspecialchars($deskripsi); ?></p>
                <form method="POST" action="">
                    <input type="hidden" name="id_kelas" value="<?php echo $row['id_kelas']; ?>" />
                    <button type="submit" class="btn">Pilih Kelas</button>
                </form>
            </div>
        <?php }
        } else {
            echo "<p>Tidak ada data tersedia.</p>";
        } ?>
    </section>

    <!-- Menampilkan Keranjang -->
    <?php if (!empty($_SESSION['keranjang'])): ?>
        <section class="keranjang" id="keranjang">
            <h3>Kelas yang Dipilih:</h3>
            <ul>
                <?php
                foreach ($_SESSION['keranjang'] as $id_kelas) {
                    $query_kelas = "SELECT * FROM kelas WHERE id_kelas = :id_kelas";
                    $stmt_kelas = $pdo->prepare($query_kelas);
                    $stmt_kelas->execute([':id_kelas' => $id_kelas]);
                    $kelas = $stmt_kelas->fetch(PDO::FETCH_ASSOC);
                    if ($kelas) {
                        echo '<li>' . htmlspecialchars($kelas['nama_kelas']) . ' 
                        <a href="?remove=' . $kelas['id_kelas'] . '" class="btn">Hapus</a></li>';
                    }
                }
                ?>
            </ul>
            <a href="progress.php" class="checkout-btn">Checkout</a>
        </section>
    <?php endif; ?>

</main>

<footer>
    <div class="container">
        <div class="social-icons mb-3">
            <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
            <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
            <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
            <a href="#"><img src="images/instagram-icon.png" alt="Instagram" /></a>
        </div>
        <nav>
            <a href="index.php" class="me-3 text-decoration-none">Home</a>
            <a href="aboutUs.php" class="me-3 text-decoration-none">About Us</a>
            <a href="product.php" class="me-3 text-decoration-none">Product</a>
            <a href="profil.php" class="text-decoration-none">Login</a>
        </nav>
        <p class="mt-3">
            &copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love
        </p>
    </div>
</footer>

<script>
// Fungsi untuk membuat keranjang bisa digeser-geser
let dragItem = document.querySelector("#keranjang");
let currentX, currentY, initialX, initialY, xOffset = 0, yOffset = 0;

dragItem.addEventListener("mousedown", dragStart, false);
window.addEventListener("mouseup", dragEnd, false);
window.addEventListener("mousemove", drag, false);

function dragStart(e) {
    initialX = e.clientX - xOffset;
    initialY = e.clientY - yOffset;
    dragItem.style.transition = "none"; // Matikan transisi saat drag
}

function dragEnd(e) {
    initialX = currentX;
    initialY = currentY;
    dragItem.style.transition = "transform 0.3s ease"; // Aktifkan kembali transisi
}

function drag(e) {
    if (dragItem.style.transition === "none") {
        currentX = e.clientX - initialX;
        currentY = e.clientY - initialY;
        xOffset = currentX;
        yOffset = currentY;

        dragItem.style.transform = "translate(" + currentX + "px, " + currentY + "px)";
    }
}
</script>
</body>
</html>
