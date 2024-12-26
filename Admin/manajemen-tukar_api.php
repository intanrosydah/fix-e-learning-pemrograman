<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_user = $_POST['id_user'];
  $id_paket_api = $_POST['id_paket_api'];
  $api_ditukarkan = $_POST['api_ditukarkan'];
  $waktu_penukaran = date('Y-m-d H:i:s');
  $status_penukaran = $_POST['status_penukaran'];

  $sql = "INSERT INTO tukar_api (id_user, id_paket_api, api_ditukarkan, waktu_penukaran, status_penukaran) 
            VALUES (:id_user, :id_paket_api, :api_ditukarkan, :waktu_penukaran, :status_penukaran)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_paket_api' => $id_paket_api,
    ':api_ditukarkan' => $api_ditukarkan,
    ':waktu_penukaran' => $waktu_penukaran,
    ':status_penukaran' => $status_penukaran
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_tukar_api = $_POST['id_tukar_api'];
  $id_user = $_POST['id_user'];
  $id_paket_api = $_POST['id_paket_api'];
  $api_ditukarkan = $_POST['api_ditukarkan'];
  $status_penukaran = $_POST['status_penukaran'];

  $sql = "UPDATE tukar_api 
            SET id_user = :id_user, id_paket_api = :id_paket_api, api_ditukarkan = :api_ditukarkan, status_penukaran = :status_penukaran
            WHERE id_tukar_api = :id_tukar_api";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_paket_api' => $id_paket_api,
    ':api_ditukarkan' => $api_ditukarkan,
    ':status_penukaran' => $status_penukaran,
    ':id_tukar_api' => $id_tukar_api
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_tukar_api = $_GET['id'];

  $sql = "DELETE FROM tukar_api WHERE id_tukar_api = :id_tukar_api";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_tukar_api' => $id_tukar_api]);
}

// Query untuk mendapatkan data dengan JOIN
$sql = "SELECT tukar_api.id_tukar_api, user.name AS nama_pengguna, paket.nama_paket, tukar_api.api_ditukarkan, tukar_api.waktu_penukaran, tukar_api.status_penukaran
        FROM tukar_api
        JOIN user ON tukar_api.id_user = user.id
        JOIN paket ON tukar_api.id_paket_api = paket.id_paket";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Tukar API</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
  require 'sidebar.php';
  ?>

  <!-- Main Content -->
  <div class="content pt-5 mt-3">
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>TUKAR API</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Penukaran</button>
          <button class="btn btn-primary me-2">Excel</button>
          <button class="btn btn-primary me-2">Word</button>
          <button class="btn btn-primary">PDF</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Tukar Api</th>
              <th>Nama Pengguna</th>
              <th>Nama Paket</th>
              <th>API Ditukarkan</th>
              <th>Waktu Penukaran</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              foreach ($result as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_tukar_api']) . "</td>
                        <td>" . htmlspecialchars($row['nama_pengguna']) . "</td>
                        <td>" . htmlspecialchars($row['nama_paket']) . "</td>
                        <td>" . htmlspecialchars($row['api_ditukarkan']) . "</td>
                        <td>" . date('d/m/Y H:i:s', strtotime($row['waktu_penukaran'])) . "</td>
                        <td>" . htmlspecialchars($row['status_penukaran']) . "</td>
                        <td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_tukar_api'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_tukar_api'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>
                      </tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Modal Tambah -->
      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Penukaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id_user" class="form-label">Nama Pengguna</label>
                  <select class="form-control" name="id_user" required>
                    <option value="">Pilih Nama Pengguna</option>
                    <?php
                    $sql_user = "SELECT id, name FROM user";
                    $stmt_user = $pdo->query($sql_user);
                    while ($user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $user['id'] . "'>" . $user['name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="id_paket_api" class="form-label">Nama Paket</label>
                  <select class="form-control" name="id_paket_api" required>
                    <option value="">Pilih Nama Paket</option>
                    <?php
                    $sql_paket = "SELECT id_paket, nama_paket FROM paket";
                    $stmt_paket = $pdo->query($sql_paket);
                    while ($paket = $stmt_paket->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $paket['id_paket'] . "'>" . $paket['nama_paket'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="api_ditukarkan" class="form-label">API Ditukarkan</label>
                  <select type="number" class="form-control" name="api_ditukarkan" required>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="200">200</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="status_penukaran" class="form-label">Status Penukaran</label>
                  <select class="form-control" name="status_penukaran" required>
                    <option value="berhasil">Berhasil</option>
                    <option value="gagal">Gagal</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <input type="hidden" name="action" value="create">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
