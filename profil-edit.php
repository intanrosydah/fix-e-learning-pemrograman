<?php
session_start();
include 'config.php'; // File koneksi database
include 'header-login.php';

// Cek jika user belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: loginfix.php'); // Redirect ke halaman login jika belum login
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil data dari form
        $user_id = $_SESSION['user_id']; // Mengambil ID user dari session
        $name = $_POST['name'];

        // Validasi ID user dan dapatkan data user
        $query = "SELECT id, name, foto_profil FROM user WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_user) {
            $message = "User tidak ditemukan!";
        } else {
            $foto_profil = null;

            // Menangani upload file foto profil
            if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
                // Validasi file gambar
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_tmp = $_FILES['foto_profil']['tmp_name'];
                $file_type = mime_content_type($file_tmp);
                if (!in_array($file_type, $allowed_types)) {
                    $message = "Hanya file gambar yang diperbolehkan untuk foto profil.";
                } else {
                    $foto_profil = file_get_contents($file_tmp);
                }
            }

            // Update nama dan foto profil
            $query = "UPDATE user SET name = :name, foto_profil = :foto WHERE id = :user_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            if ($foto_profil) {
                $stmt->bindParam(':foto', $foto_profil, PDO::PARAM_LOB);
            } else {
                $stmt->bindValue(':foto', $existing_user['foto_profil'], PDO::PARAM_LOB);
            }
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Profil berhasil diperbarui!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    // Handle GET request: Fetch user data if available
    try {
        $user_id = $_SESSION['user_id']; // Ambil ID user dari session
        $query = "SELECT id, name, foto_profil FROM user WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_user) {
            $message = "User tidak ditemukan!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Profil</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        /* Body background image */
        body {
            background-image: url("images/bg_profil.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            color: #000;
        }

        .navbar {
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(9, 38, 53, 0.5);
            backdrop-filter: blur(10px);
            transition: background-color 0.3s ease, transform 0.3s ease;
            transform-origin: center top;
        }

        .navbar:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .navbar.zoom-in {
            transform: scale(1.05);
        }

        .navbar.zoom-out {
            transform: scale(1) translateY(-10px);
        }

        .navbar-brand img {
            max-width: 200px;
        }

        .navbar-nav .nav-link {
            padding: 8px 15px;
        }

        footer {
            background-color: #092635;
            color: white;
            padding: 20px;
        }

        .social-icons a img {
            width: 30px;
            margin-right: 10px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .profile-container {
            padding-top: 100px;
        }

        .profile-header h1 {
            margin: 0;
            position: relative;
        }

        .profile-section {
            margin-top: 30px;
        }

        .profile-section img {
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="profil.php">
                <img src="images/new-logo.png" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="product-login.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="progress.php">Progress</a></li>
                    <li class="nav-item"><a class="nav-link" href="daily-coding.php">Daily Coding</a></li>
                    <li class="nav-item"><a class="nav-link active" href="profil.php">Profil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Container -->
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 600px; margin: 70px auto;">
            <div class="card-body">
                <h3 class="card-title text-center my-5">Update Profil</h3>
                <?php if ($message) : ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if (isset($existing_user)) : ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $existing_user['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Pilih Foto Profil</label>
                            <input type="file" name="foto_profil" id="foto_profil" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-dark mt-5 w-100">Update</button>
                    </form>
                <?php else : ?>
                    <div class="alert alert-warning">User tidak ditemukan.</div>
                <?php endif; ?>
                <a href="profil.php" class="btn btn-secondary w-100 btn-back my-3 mb-5">Back to Profil</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
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
            <p class="mt-3">&copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>