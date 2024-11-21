<?php
require 'header.php';
include 'config.php'; // Koneksi database

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
        padding: 50px 70px;
        margin-bottom: 20px;
        font-size: 1.2rem;
        font-weight: 500;
        text-transform: uppercase;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-package:hover {
        background-color: #e6e6e6;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .btn-package.active {
        background-color: #a8a7a7;
        color: #092635;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
    }

    .btn-package:focus {
        outline: none;
    }

    .btn-dark {
        background-color: #092635;
        border: none;
        padding: 15px;
        font-size: 1.1rem;
        border-radius: 8px;
        text-transform: uppercase;
        transition: background 0.3s ease;
    }

    .btn-dark:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .btn-dark:hover:not(:disabled) {
        background-color: #092635;
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
        <form id="paketForm" action="pembayaran.php" method="POST">
            <?php foreach ($paket_list as $paket) : ?>
                <button type="button" class="btn-package" data-value="<?= $paket['id_paket'] ?>">
                    <?= htmlspecialchars($paket['nama_paket']) ?> - Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?>
                </button>
            <?php endforeach; ?>
            <input type="hidden" name="package" id="selectedPackage">
            <button type="submit" class="btn btn-dark w-100 mt-3" disabled id="submitButton">Pilih</button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container text-center">
        <div class="social-icons mb-4">
            <a href="#"><img src="images/facebook-icon.png" alt="Facebook" /></a>
            <a href="#"><img src="images/x-icon.png" alt="Twitter" /></a>
            <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" /></a>
            <a href="#"><img src="images/instagram-icon.png" alt="Instagram" /></a>
        </div>
        <div class="footer-nav">
            <a href="index.php">Home</a>
            <a href="aboutUs.php">About Us</a>
            <a href="product.php">Product</a>
            <a href="profil.php">Login</a>
        </div>
        <p class="footer-text mt-3">&copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love</p>
    </div>
</footer>

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
<script>
    const buttons = document.querySelectorAll('.btn-package');
    const selectedPackageInput = document.getElementById('selectedPackage');
    const submitButton = document.getElementById('submitButton');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Hapus class active dari semua tombol
            buttons.forEach(btn => btn.classList.remove('active'));

            // Tambahkan class active ke tombol yang dipilih
            button.classList.add('active');

            // Set value paket yang dipilih
            selectedPackageInput.value = button.getAttribute('data-value');

            // Aktifkan tombol submit
            submitButton.disabled = false;
        });
    });
</script>