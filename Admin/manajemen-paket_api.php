<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nama_paket_api = $_POST['nama_paket_api'];
    $api_minimal = $_POST['api_minimal'];

    $sql = "INSERT INTO paket_api (nama_paket_api, api_minimal) VALUES (:nama_paket_api, :api_minimal)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_paket_api' => $nama_paket_api,
        ':api_minimal' => $api_minimal
    ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_paket_api = $_POST['id_paket_api'];
    $nama_paket_api = $_POST['nama_paket_api'];
    $api_minimal = $_POST['api_minimal'];

    $sql = "UPDATE paket_api SET nama_paket_api = :nama_paket_api, api_minimal = :api_minimal WHERE id_paket_api = :id_paket_api";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_paket_api' => $nama_paket_api,
        ':api_minimal' => $api_minimal,
        ':id_paket_api' => $id_paket_api
    ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_paket_api = $_GET['id'];

    $sql = "DELETE FROM paket_api WHERE id_paket_api = :id_paket_api";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_paket_api' => $id_paket_api]);
}

// Query untuk mendapatkan data
$sql = "SELECT * FROM paket_api ORDER BY id_paket_api ASC";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Paket API</title>
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
        <h3>PAKET API</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Paket API</button>
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
                <th>ID Paket API</th>
                <th>Nama Paket API</th>
                <th>API Minimal</th>
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
                echo "<td>" . htmlspecialchars($row['id_paket_api']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_paket_api']) . "</td>";
                echo "<td>" . htmlspecialchars($row['api_minimal']) . "</td>";
                echo "<td>
                           <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_paket_api'] . "'>Edit</button>
                           <a href='?action=delete&id=" . $row['id_paket_api'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                echo "</tr>";

                // Modal Edit
                echo "
                <div class='modal fade' id='editModal" . $row['id_paket_api'] . "' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Data</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_paket_api' value='" . htmlspecialchars($row['id_paket_api']) . "'>
                                    <div class='mb-3'>
                                        <label for='nama_paket_api' class='form-label'>Nama Paket API</label>
                                        <input type='text' class='form-control' name='nama_paket_api' value='" . htmlspecialchars($row['nama_paket_api']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='api_minimal' class='form-label'>API Minimal</label>
                                        <input type='number' class='form-control' name='api_minimal' value='" . htmlspecialchars($row['api_minimal']) . "' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                    <button type='submit' class='btn btn-primary'>Simpan</button>
                                    <input type='hidden' name='action' value='update'>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";
              }
            }
            ?>
          </tbody>
        </table>
    </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_paket_api" class="form-label">Nama Paket API</label>
                                <input type="text" class="form-control" name="nama_paket_api" required>
                            </div>
                            <div class="mb-3">
                                <label for="api_minimal" class="form-label">API Minimal</label>
                                <input type="number" class="form-control" name="api_minimal" required>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>