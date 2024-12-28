<?php
session_start();
include 'config.php'; // File koneksi database
require 'header-login.php';

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

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require 'footer.php'; ?>
</body>

</html>