<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>

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

        .form-outline input {
            border-radius: 0.25rem;
        }

        .form-label {
            color: #bbb;
        }

        .h-custom {
            height: 100vh;
        }

        @media (max-width: 768px) {
            .img-fluid {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php
    require 'config.php';

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Ambil data dari form
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password

            // Query untuk menyimpan data
            $sql = "INSERT INTO user (name, username, email, password) VALUES (:name, :username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            // Bind parameter
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            // Eksekusi query
            $stmt->execute();

            $message = "Registrasi berhasil!";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
    ?>

    <section class="vh-100">
        <div class="container py-5 h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid"
                        alt="Sample image"
                    />
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post">
                        <div
                            class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4"
                        >
                            <p class="lead fw-normal text-center me-3">REGISTER</p>
                        </div>

                        <?php if ($message): ?>
                            <div class="alert alert-info">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Nama -->
                        <div class="form-outline mb-4">
                            <input
                                type="text"
                                id="formName"
                                class="form-control form-control-lg"
                                name="name"
                                placeholder="Enter your name"
                                required
                            />
                            <label class="form-label" for="formName">Name</label>
                        </div>

                        <!-- Username -->
                        <div class="form-outline mb-4">
                            <input
                                type="text"
                                id="formUsername"
                                class="form-control form-control-lg"
                                name="username"
                                placeholder="Enter your username"
                                required
                            />
                            <label class="form-label" for="formUsername">Username</label>
                        </div>

                        <!-- Email -->
                        <div class="form-outline mb-4">
                            <input
                                type="email"
                                id="formEmail"
                                class="form-control form-control-lg"
                                name="email"
                                placeholder="Enter a valid email"
                                required
                            />
                            <label class="form-label" for="formEmail">Email address</label>
                        </div>

                        <!-- Password -->
                        <div class="form-outline mb-3">
                            <input
                                type="password"
                                id="formPassword"
                                class="form-control form-control-lg"
                                name="password"
                                placeholder="Enter password"
                                required
                            />
                            <label class="form-label" for="formPassword">Password</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem"
                            >
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
