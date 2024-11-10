<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIFYCODE Learning</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
    body { font-family: "Montserrat", sans-serif; background-color: #092635; color: white; }
    .navbar { padding: 0; position: fixed; top: 0; width: 100%; z-index: 1000; background-color: rgba(9, 38, 53, 0.5); backdrop-filter: blur(10px); transition: background-color 0.3s ease, transform 0.3s ease; }
    .navbar:hover { background-color: rgba(0, 0, 0, 0.5); }
    .navbar.zoom-in { transform: scale(1.05); }
    .navbar.zoom-out { transform: scale(1) translateY(-10px); }
    .navbar-brand img { max-width: 200px; }
    .navbar-nav .nav-link { padding: 8px 15px; }
    footer { background-color: #092635; color: white; padding: 20px; }
    .bg-light { background-color: #092635 !important; color: white !important; }
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="images/new-logo.png" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
                <li class="nav-item"><a class="nav-link" href="loginfix.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="content">
