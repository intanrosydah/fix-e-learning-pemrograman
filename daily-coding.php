<?php
require 'header-login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tantangan Harian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #092635;
            color: white;
        }
        .content { margin-top: 150px; }
        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        
        .soal-harian {
            color: #007bff; /* Warna biru untuk soal */
        }
        .reward-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 20px;
    background-color: rgba(9, 38, 53, 0.7);
    border-radius: 8px;
    .reward-header .btn {
    padding: 10px 20px;
}

}

        
    </style>
</head>
<body>

<div class="content">
    <h1 class="text-center my-4">Tantangan Harian</h1>
 <!-- Reward Header -->
 <div class="d-flex justify-content-between align-items-center  p-5 rounded">
 <div class="reward-header mx-auto mb-4">
    <a href="tukar-api.php" class="btn btn-danger">Tukar Api</a>
    <span class="fs-4 fw-bold">6</span>
</div>

      </div>
    <!-- Nav Pills -->
    <ul class="nav nav-pills justify-content-center mb-4">
        <li class="nav-item">
            <a class="nav-link active" id="day1-tab" data-bs-toggle="pill" href="#day1">Hari 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day2-tab" data-bs-toggle="pill" href="#day2">Hari 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day3-tab" data-bs-toggle="pill" href="#day3">Hari 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day4-tab" data-bs-toggle="pill" href="#day4">Hari 4</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day5-tab" data-bs-toggle="pill" href="#day5">Hari 5</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day6-tab" data-bs-toggle="pill" href="#day6">Hari 6</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="day7-tab" data-bs-toggle="pill" href="#day7">Hari 7</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content container">

        <!-- Hari 1 -->
        <div class="tab-pane fade show active" id="day1">
        <div class="card ">
                <h3 class="soal-harian">Soal Hari Ke-1</h3>
                <p class="fw-bold soal-harian">Buat program untuk menghitung faktorial dari sebuah angka yang dimasukkan oleh pengguna.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk menghitung faktorial
n = int(input("Masukkan angka: "))
faktorial = 1
for i in range(1, n + 1):
    faktorial *= i
print(f"Faktorial dari {n} adalah {faktorial}")
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 2 -->
        <div class="tab-pane fade" id="day2">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-2</h3>
                <p class="fw-bold soal-harian">Buat program untuk menentukan apakah sebuah angka adalah bilangan prima atau bukan.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk cek bilangan prima
n = int(input("Masukkan angka: "))
prima = True
for i in range(2, int(n / 2) + 1):
    if n % i == 0:
        prima = False
        break
if prima:
    print(f"{n} adalah bilangan prima.")
else:
    print(f"{n} bukan bilangan prima.")
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 3 -->
        <div class="tab-pane fade" id="day3">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-3</h3>
                <p class="fw-bold soal-harian">Buat program untuk menampilkan angka Fibonacci ke-n yang dimasukkan oleh pengguna.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk menampilkan angka Fibonacci
n = int(input("Masukkan angka n: "))
a, b = 0, 1
for i in range(n):
    print(a, end=" ")
    a, b = b, a + b
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 4 -->
        <div class="tab-pane fade" id="day4">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-4</h3>
                <p class="fw-bold soal-harian">Buat program untuk menghitung angka terbesar dalam sebuah daftar.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk mencari angka terbesar dalam daftar
daftar = [1, 3, 5, 7, 9]
print("Angka terbesar:", max(daftar))
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 5 -->
        <div class="tab-pane fade" id="day5">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-5</h3>
                <p class="fw-bold soal-harian">Buat program untuk mengurutkan daftar angka.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk mengurutkan angka
daftar = [5, 2, 9, 1, 5, 6]
daftar.sort()
print("Daftar angka yang diurutkan:", daftar)
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 6 -->
        <div class="tab-pane fade" id="day6">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-6</h3>
                <p class="fw-bold soal-harian">Buat program untuk menentukan angka ganjil atau genap.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk cek ganjil atau genap
n = int(input("Masukkan angka: "))
if n % 2 == 0:
    print(f"{n} adalah angka genap.")
else:
    print(f"{n} adalah angka ganjil.")
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Hari 7 -->
        <div class="tab-pane fade" id="day7">
            <div class="card">
                <h3 class="soal-harian">Soal Hari Ke-7</h3>
                <p class="fw-bold soal-harian">Buat program untuk mencari nilai rata-rata dari sebuah daftar angka.</p>
                <textarea class="form-control mb-3" placeholder="Tulis kode Anda..." style="height: 150px">
// Program untuk mencari rata-rata
daftar = [1, 2, 3, 4, 5]
rata_rata = sum(daftar) / len(daftar)
print("Rata-rata angka:", rata_rata)
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
                    <a href="daily-coding.php" class="btn btn-success">Lanjut</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
            </div>
        </div>

    </div>

</div>

<?php
require 'footer.php';
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
