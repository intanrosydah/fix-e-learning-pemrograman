<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tantangan Harian - Hari Ke-3</title>

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

      .navbar {
        padding: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: rgba(9, 38, 53, 0.5); /* Transparansi */
        backdrop-filter: blur(10px); /* Efek blur */
        transition: background-color 0.3s ease, transform 0.3s ease;
        transform-origin: center top;
      }

      /* Navbar menjadi lebih transparan saat di-hover */
      .navbar:hover {
        background-color: rgba(0, 0, 0, 0.5);
      }

      /* Efek zoom in dan zoom out */
      .navbar.zoom-in {
        transform: scale(1.05);
      }

      .navbar.zoom-out {
        transform: scale(1) translateY(-10px); /* Tetap full-width dan turun sedikit */
      }

      .navbar-brand img {
        max-width: 200px;
      }

      .navbar-nav .nav-link {
        padding: 8px 15px;
      }


     .fire-icon {
      animation: flameAnimation 1s infinite alternate ease-in-out;
    }

    @keyframes flameAnimation {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.2);
      }
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
   </style>
 </head>
 <body>

   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark ">
     <div class="container">
       <a class="navbar-brand" href="index.html">
         <img src="images/new-logo.png" alt="Logo" />
       </a>
       <button
         class="navbar-toggler"
         type="button"
         data-bs-toggle="collapse"
         data-bs-target="#navbarNav"
         aria-controls="navbarNav"
         aria-expanded="false"
         aria-label="Toggle navigation"
       >
         <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="progress.html">Progress</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="daily-coding.html">Daily Coding</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profil.html">Profil</a>
          </li>
         </ul>
       </div>
     </div>
   </nav>

   <!-- Main Content -->
   <div class="text-center mt-5 pt-5">
    <h1>Daily Coding</h1>
  </div>

  <main class="container my-5">
    <div class="card bg-white p-4 rounded shadow-sm mx-auto col-12 col-md-8">
      <!-- Reward Header -->
      <div class="d-flex justify-content-between align-items-center bg-warning p-5 rounded">
        <h1 class="mb-0">Api Saya</h1>
        <div class="d-flex align-items-center gap-3">
          <a href="tukar-api.html" class="btn btn-danger">Tukar Api</a>
          <span class="fs-4 fw-bold">2</span>
        </div>
      </div>

      <!-- Reward Section -->
      <div class="d-flex justify-content-between mt-4 gap-3">
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 1</p>
        </div>
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 2</p>
        </div>
        <div class="text-center text-dark p-2 border rounded shadow-sm border-warning border-4">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari ini</p>
        </div>
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 4</p>
        </div>
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 5</p>
        </div>
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 6</p>
        </div>
        <div class="text-center text-dark p-3 border rounded shadow-sm">
          <span class="flow-bold">+1 Api</span>
          <p class="mb-0">Hari 7</p>
        </div>
      </div>
    </main>
        
    <!-- Challenge Section -->
    <main class="container my-5">
      <div class="card bg-white p-4 rounded shadow-sm mx-auto col-12 col-md-8">
        <div class="text-center text-dark mt-5">
          <h2>Tantangan Harian - Hari Ke-3</h2>
          <p>Tingkatkan kemampuan coding Anda dengan tantangan harian</p>
        </div> 

        <div class="container mt-5">
          <div class="text-center text-dark">
            <h3>Tantangan Saat Ini:</h3>
          </div>
        </div>
          
        <div class="border border-3 border-warning-subtle rounded p-4 mt-3">
          <p class="fw-bold text-center text-dark">Buat program yang membantu pengguna untuk mengelola anggaran bulanan mereka. Program ini harus menerima pengeluaran untuk berbagai kategori seperti makanan, transportasi, hiburan, dan lain-lain, kemudian menghitung total pengeluaran dan memberikan saran apakah anggaran pengguna melebihi batas yang ditentukan.</p>
          <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px;"
            >
            # Fungsi untuk memeriksa apakah dua kata adalah anagram
            def is_anagram(kata1, kata2):
                return sorted(kata1.lower()) == sorted(kata2.lower())
            
            # Meminta input dua kata dari pengguna
            kata1 = input("Masukkan kata pertama: ")
            kata2 = input("Masukkan kata kedua: ")

            # Memeriksa apakah keduanya adalah anagram
            if is_anagram(kata1, kata2):
                print(f"{kata1} dan {kata2} adalah anagram.")
            else :
                print(f"{kata1} dan {kata2} bukan anagram.")
              </textarea>
              <div class="mt-2">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">kirim kode</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content text-center">
                      <div class="modal-body">
                        <h2 class="text-warning fw-bold">Selamat!</h2>
                        <img src="https://img.icons8.com/emoji/48/fire.png" alt="Fire" width="60" class="fire-icon mt-4 gap-5">
                        <p class="text-center text-dark fs-3">Anda telah menyelesaikan tantangan hari ini!</p>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <a href="kode-daily-coding-hari3.html" class="btn btn-success">Lanjut</a>
                      </div>
                    </div>
                  </div>
                </div>
                <a href="daily-coding-hari4.html" class="btn btn-dark ms-2">Lanjut Hari Berikutnya</a>
              </div>
          </div>
    
          <div class="mt-3 text-center text-dark">
            <p>Selesaikan tantangan dan dapatkan Api. Kumpulkan 100 Api untuk membuka kursus lanjutan!</p>
          </div>          
        </main>
    
<!-- Footer -->
<footer class="text-center">
  <div class="container">
      <div class="social-icons mb-3">
          <a href="#"><img src="images/facebook-icon.png" alt="Facebook" style="width: 30px; margin-right: 10px;" /></a>
          <a href="#"><img src="images/x-icon.png" alt="Twitter" style="width: 30px; margin-right: 10px;" /></a>
          <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn" style="width: 30px; margin-right: 10px;" /></a>
          <a href="#"><img src="images/instagram-icon.png" alt="Instagram" style="width: 30px; margin-right: 10px;" /></a>
      </div>
      <nav>
          <a href="index.html" class="text-decoration-none me-3">Home</a>
          <a href="aboutUs.html" class="text-decoration-none me-3">About Us</a>
          <a href="product.html" class="text-decoration-none me-3">Product</a>
          <a href="profil.html" class="text-decoration-none">Login</a>
      </nav>
      <p class="mt-3">&copy; 2024 AIFYCODE Learning | All Rights Reserved. Made With Love</p>
  </div>
</footer>

<script>
  function showPopup() {
      document.getElementById("popupContainer").style.display = "flex";
  }

  function closePopup() {
      document.getElementById("popupContainer").style.display = "none";
  }

  function claimReward() {
      alert("Selamat! Anda telah mendapatkan 1 Api.");
  }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Fungsi untuk menampilkan modal Bootstrap
function showPopup() {
  const victoryModal = new bootstrap.Modal(document.getElementById('victoryModal'));
  victoryModal.show();
}
</script>

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