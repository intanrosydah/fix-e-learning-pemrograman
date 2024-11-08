<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

      .form-outline input {
        border-radius: 0.25rem;
      }

      .form-label {
        color: #bbb;
      }

      .divider:after,
      .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
      }

      .h-custom {
        height: 100vh;
      }

      .social-icons button {
        border: none;
      }

      .bg-primary {
        background-color: #007bff !important;
      }
      .btn-primary {
        margin-bottom: 50px;
      }

      @media (max-width: 768px) {
        .img-fluid {
          display: none;
        }
      }
    </style>
  </head>
  <body>
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
            <form id="loginForm">
              <div
                class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4"
              >
                <p class="lead fw-normal text-center me-3">REGISTER</p>
              </div>

              <!-- Nama -->
              <div class="form-outline mb-4">
                <input
                  type="text"
                  id="formName"
                  class="form-control form-control-lg"
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
                  placeholder="Enter password"
                  required
                />
                <label class="form-label" for="formPassword">Password</label>
              </div>

              <!-- Repeat Password -->
              <div class="form-outline mb-3">
                <input
                  type="password"
                  id="formRepeatPassword"
                  class="form-control form-control-lg"
                  placeholder="Repeat password"
                  required
                />
                <label class="form-label" for="formRepeatPassword"
                  >Repeat password</label
                >
              </div>

              <div class="text-center text-lg-start mt-4 pt-2">
                <button
                  type="submit"
                  class="btn btn-primary btn-lg"
                  style="padding-left: 2.5rem; padding-right: 2.5rem"
                >
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault(); // Mencegah form dari submit secara normal

          const name = document.getElementById("formName").value;
          const username = document.getElementById("formUsername").value;
          const email = document.getElementById("formEmail").value;
          const password = document.getElementById("formPassword").value;
          const repeatPassword =
            document.getElementById("formRepeatPassword").value;

          // Validasi sederhana
          if (password !== repeatPassword) {
            alert("Passwords do not match. Please try again.");
            return; // Keluar dari fungsi jika password tidak cocok
          }

          if (name && username && email && password) {
            alert("Login successful!");
            window.location.href = "profil.php"; // Redirect ke profil.php
          } else {
            alert("Please fill in all fields.");
          }
        });
    </script>
  </body>
</html>
