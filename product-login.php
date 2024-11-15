<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        /* Body background image */
        body {
            background-image: url("images/bg_produk.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            color: #fff;
        }

        .navbar {
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(9, 38, 53, 0.7);
            backdrop-filter: blur(10px);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .navbar-brand img {
            max-width: 180px;
        }

        .navbar-nav .nav-link {
            padding: 8px 15px;
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

        .card {
            border: none;
            color: #092635;
            background: rgba(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .form-check {
            font-size: 1.2rem;
        }

        .form-check-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/new-logo.png" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product-login.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="progress.php">Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daily-coding.php">Daily Coding</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profil.php">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="product-container">
            <h2>Pilih Paket Kursus</h2>
            <form action="pembayaran.php" method="POST">
                <div class="card p-4 mb-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="package" value="1" id="package1" checked>
                        <label class="form-check-label" for="package1">Paket 1 Bulan - Rp 1,000,000</label>
                    </div>
                </div>
                <div class="card p-4 mb-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="package" value="2" id="package2">
                        <label class="form-check-label" for="package2">Paket 3 Bulan - Rp 3,000,000</label>
                    </div>
                </div>
                <div class="card p-4 mb-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="package" value="3" id="package3">
                        <label class="form-check-label" for="package3">Paket 6 Bulan - Rp 5,100,000</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark w-100">Pilih</button>
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
</body>

</html>