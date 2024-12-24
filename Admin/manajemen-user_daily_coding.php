<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_user = $_POST['id_user'];
  $hari_tantangan = $_POST['hari_tantangan'];
  $kode_soal = $_POST['kode_soal'];
  $jawaban_user = $_POST['jawaban_user'];
  $status_tantangan = $_POST['status_tantangan'];
  $perolehan_api = $_POST['perolehan_api'];

  $sql = "INSERT INTO user_daily_coding (id_user, hari_tantangan, kode_soal, jawaban_user, status_tantangan, perolehan_api) 
          VALUES (:id_user, :hari_tantangan, :kode_soal, :jawaban_user, :status_tantangan, :perolehan_api)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':hari_tantangan' => $hari_tantangan,
    ':kode_soal' => $kode_soal,
    ':jawaban_user' => $jawaban_user,
    ':status_tantangan' => $status_tantangan,
    ':perolehan_api' => $perolehan_api
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_user = $_POST['id_user'];
  $hari_tantangan = $_POST['hari_tantangan'];
  $kode_soal = $_POST['kode_soal'];
  $jawaban_user = $_POST['jawaban_user'];
  $status_tantangan = $_POST['status_tantangan'];
  $perolehan_api = $_POST['perolehan_api'];

  $sql = "UPDATE user_daily_coding 
          SET hari_tantangan = :hari_tantangan, kode_soal = :kode_soal, jawaban_user = :jawaban_user, 
              status_tantangan = :status_tantangan, perolehan_api = :perolehan_api
          WHERE id_user = :id_user";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':hari_tantangan' => $hari_tantangan,
    ':kode_soal' => $kode_soal,
    ':jawaban_user' => $jawaban_user,
    ':status_tantangan' => $status_tantangan,
    ':perolehan_api' => $perolehan_api,
    ':id_user' => $id_user
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_user = $_GET['id'];

  $sql = "DELETE FROM user_daily_coding WHERE id_user = :id_user";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_user' => $id_user]);
}

// Query untuk mendapatkan data
$sql = "SELECT * FROM user_daily_coding ORDER BY id_user ASC";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - User Daily Coding</title>
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
  <?php
  require 'sidebar.php'
  ?>

  <!-- Main Content -->
  <div class="content pt-5 mt-3">
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>USER DAILY CODING</h3>
        <div>
        <button class="btn btn-primary me-2">Excel</button>
          <button class="btn btn-primary me-2">Word</button>
          <button class="btn btn-primary">PDF</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID User</th>
              <th>Hari Tantangan</th>
              <th>Kode Soal</th>
              <th>Jawaban User</th>
              <th>Status Tantangan</th>
              <th>Perolehan API</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              $no = 1;
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['id_user']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hari_tantangan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kode_soal']) . "</td>";
                echo "<td>" . htmlspecialchars($row['jawaban_user']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status_tantangan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['perolehan_api']) . "</td>";
                echo "<td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_user'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_user'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>