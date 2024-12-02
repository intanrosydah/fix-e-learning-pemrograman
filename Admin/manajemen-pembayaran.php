<?php
include 'config2.php'; // File koneksi database

// Query untuk mendapatkan data pembayaran
$sql = "SELECT id_langganan, id, id_paket, id_metode_pembayaran, nomor_va, tanggal_mulai, tanggal_selesai FROM langganan";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Manajemen Pembayaran</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      min-height: 100vh;
    }

    .sidebar {
      min-height: 100vh;
      width: 250px;
      background-color: #343a40;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 100;
      color: white;
      padding-top: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 15px;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
    }

    .navbar-brand img {
      border-radius: 50%;
      width: 30px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-3">
      <img
        src="https://via.placeholder.com/50"
        class="rounded-circle"
        alt="User" />
      <p>Admin</p>
    </div>
    <a href="#">Home</a>
    <a href="manajemen-pembayaran.php">Riwayat Pembayaran</a>
    <a href="index.php">Logout</a>
  </div>

  <!-- Header/Navbar -->
  <nav
    class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
    style="margin-left: 250px">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="images/new-logo.png" alt="Logo" />
        AIFYCODE Learning
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
        <form class="d-flex">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            aria-label="Search" />
          <button class="btn btn-outline-success" type="submit">
            Search
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content pt-5 mt-3">
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>RIWAYAT PEMBAYARAN</h3>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Langganan</th>
              <th>ID User</th>
              <th>ID Paket</th>
              <th>ID Metode Pembayaran</th>
              <th>Nomor VA</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              $no = 1;
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['id_paket']) . "</td>";
                echo "<td>" . htmlspecialchars($row['id_metode_pembayaran']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nomor_va']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tanggal_mulai']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tanggal_selesai']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>