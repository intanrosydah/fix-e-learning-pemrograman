<?php
require 'header-login.php';
require 'config.php'; // Koneksi database

// Query untuk mengambil data paket kursus
$query = "SELECT * FROM paket";
$stmt = $pdo->prepare($query);
$stmt->execute();
$paket_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
    /* Body background */
    body {
        background-image: url("images/bg_produk.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        font-family: "Montserrat", sans-serif;
        color: #fff;
    }

    .main-container {
        padding-top: 100px;
    }

    .product-container {
        padding: 60px 15px;
        text-align: center;
        max-width: 800px;
        margin: auto;
    }

    .product-container h2 {
        font-size: 2.5rem;
        margin-bottom: 30px;
    }

    .btn-package {
        background-color: #fff;
        color: #092635;
        border: none;
        border-radius: 8px;
        padding: 70px 200px;
        /* Sesuaikan ukuran padding */
        font-size: 1.2rem;
        font-weight: 500;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        /* Hilangkan garis bawah */
        margin: 0 auto;
        /* Pusatkan tombol */
        max-width: 100%;
        /* Tombol tidak melebihi kontainer */
    }

    .btn-package:hover {
        background-color: #e6e6e6;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .d-flex.flex-column.gap-3 {
        display: flex;
        flex-direction: column;
        gap: 30px;
        /* Jarak antar tombol */
        align-items: center;
        /* Pusatkan tombol secara horizontal */
    }


    footer {
        background-color: #092635;
        color: #fff;
        padding: 40px 0;
        position: relative;
    }

    .social-icons a img {
        width: 35px;
        margin: 0 10px;
        transition: transform 0.3s;
    }

    .social-icons a:hover img {
        transform: scale(1.1);
    }

    .footer-nav a {
        color: #fff;
        margin: 0 15px;
        font-size: 1.1rem;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-nav a:hover {
        color: #0d6efd;
    }

    .footer-text {
        font-size: 0.9rem;
        margin-top: 15px;
    }
</style>

<!-- Main Content -->
<div class="main-container">
    <div class="product-container">
        <h2>Pilih Paket Kursus</h2>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($paket_list as $paket) : ?>
                <a href="pembayaran.php?package=<?= $paket['id_paket'] ?>" class="btn-package text-center">
                    <?= htmlspecialchars($paket['nama_paket']) ?> - Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", () => {
        const scrollPos = window.scrollY;
        if (scrollPos > 50) {
            navbar.classList.add("zoom-out");
            navbar.classList.remove("zoom-in");
        } else {
            navbar.classList.add("zoom-in");
            navbar.classList.remove("zoom-out");
        }
    });
</script>