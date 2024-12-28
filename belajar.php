<?php
require 'header-login.php';
require 'config.php'; // Pastikan menggunakan koneksi PDO yang telah diatur

// Ambil id_kelas dari URL
$id_kelas = isset($_GET['id_kelas']) ? intval($_GET['id_kelas']) : null;

// Validasi jika id_kelas ada
if (!$id_kelas) {
    die("Kelas tidak ditemukan.");
}

// Ambil data modul berdasarkan id_kelas
try {
    $sql_modul = "SELECT * FROM modul WHERE id_kelas = :id_kelas";
    $stmt_modul = $pdo->prepare($sql_modul);
    $stmt_modul->execute([':id_kelas' => $id_kelas]);
    $result_modul = $stmt_modul->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #092635;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            color: #000;
        }

        .fixed-container {
            max-width: 1200px;
            margin: 120px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .back-btn {
            background-color: #2a3a5b;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background-color: #1f263b;
        }

        .module-title {
            font-size: 24px;
            font-weight: bold;
            background-color: #f2f2f2;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }

        .dropbtn {
            background-color: #2a3a5b;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .dropbtn:hover {
            background-color: #1f263b;
        }

        .dropdown-content {
            display: none;
            background-color: #f1f1f1;
            width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }

        .navigation-buttons button {
            border: none;
            background-color: #2a3a5b;
            color: white;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .navigation-buttons button:hover {
            background-color: #1f263b;
        }
    </style>
</head>
<body>
<div class="fixed-container">
    <button class="btn back-btn" onclick="window.location.href='koridor-dipelajari.php'">Koridor Kelas</button>

    <div class="module-title">Belajar Dasar AI</div>

    <div class="row">
        <div class="col-md-4">
            <h4 class="text-center text-primary">Daftar Modul</h4>

            <?php foreach ($result_modul as $modul): ?>
                <div class="dropdown">
                    <button onclick="toggleDropdown('dropdown<?php echo $modul['id_modul']; ?>')" class="dropbtn">
                        <?php echo htmlspecialchars($modul['nama_modul']); ?>
                    </button>
                    <div id="dropdown<?php echo $modul['id_modul']; ?>" class="dropdown-content">
                        <?php
                        $sql_bab = "SELECT * FROM bab WHERE id_modul = :id_modul";
                        $stmt_bab = $pdo->prepare($sql_bab);
                        $stmt_bab->execute([':id_modul' => $modul['id_modul']]);
                        while ($bab = $stmt_bab->fetch(PDO::FETCH_ASSOC)):
                            ?>
                            <a href="#" onclick="loadBab(<?php echo $bab['id_bab']; ?>, event)">
                                <?php echo htmlspecialchars($bab['nama_bab']); ?>
                            </a>
                        <?php endwhile; ?>
                        <a href="kuis.php">Kuis</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-8">
            <div class="border p-3">
                <h3 class="text-primary">Konten Materi</h3>
                <p>Pilih bab untuk melihat konten.</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button class="btn navigation-buttons">← Sebelumnya</button>
        <button class="btn navigation-buttons" onclick="window.location.href='koridor-diselesaikan.php'">Selanjutnya →</button>
    </div>
</div>

<script>
    function toggleDropdown(dropdownId) {
        closeAllDropdowns();
        document.getElementById(dropdownId).classList.toggle("show");
    }

    function closeAllDropdowns() {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.remove("show");
        }
    }

    function loadBab(idBab, event) {
        event.preventDefault(); // Mencegah reload halaman
        fetch(`get_bab_content.php?id_bab=${idBab}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(".border p").innerHTML = data.content;
                } else {
                    document.querySelector(".border p").innerHTML = data.message;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.querySelector(".border p").innerHTML = "Terjadi kesalahan saat mengambil konten.";
            });
    }

    window.onclick = function (event) {
        if (!event.target.matches(".dropbtn") && !event.target.closest(".dropdown-content")) {
            closeAllDropdowns();
        }
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$pdo = null; // Tutup koneksi
?>
