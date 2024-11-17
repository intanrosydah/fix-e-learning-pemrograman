<?php
// Include koneksi database
include 'config.php';

// Inisialisasi variabel untuk pesan error
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari pengguna berdasarkan email
    $query = "SELECT * FROM user WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validasi pengguna dan password
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect ke halaman berdasarkan peran
        if ($user['role'] === 'admin') {
            header("Location: Admin/data-pengguna.php");
        } else {
            header("Location: profil.php");
        }
        exit();
    } else {
        $error_message = 'Invalid email or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- Font Awesome CDN -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet"
    />

    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }

        /* Style default untuk input */
        input[type="email"],
        input[type="password"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        .form-check-label {
            color: #bbb;
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>
<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img
                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid"
                    alt="Sample image"
                />
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <!-- Form login -->
                <form method="POST" action="">
                    <div
                        class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-facebook-f"></i>
                        </button>

                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-google"></i>
                        </button>

                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-linkedin-in"></i>
                        </button>
                    </div>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0">Or</p>
                    </div>

                    <!-- Tampilkan pesan error -->
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input
                            type="email"
                            name="email"
                            id="form3Example3"
                            class="form-control form-control-lg"
                            placeholder="Enter a valid email"
                            required
                        />
                        <label class="form-label" for="form3Example3">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input
                            type="password"
                            name="password"
                            id="form3Example4"
                            class="form-control form-control-lg"
                            placeholder="Enter password"
                            required
                        />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>

                    <!-- Remember me and Forgot password -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check mb-0">
                            <input
                                class="form-check-input me-2"
                                type="checkbox"
                                value=""
                                id="form2Example3"
                            />
                            <label class="form-check-label" for="form2Example3">
                                Remember me
                            </label>
                        </div>
                        <a href="#!" class="body">Forgot password?</a>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem"
                        >
                            Login
                        </button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">
                            Don't have an account?
                            <a href="regist.php" class="link-danger">Register</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            &copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love
        </div>

        <!-- Social media icons -->
        <div>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-google"></i>
            </a>
            <a href="#!" class="text-white">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>
</section>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
