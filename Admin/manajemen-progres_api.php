<?php
include 'config2.php'; // Database connection file

// Add new record to progres_api
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_user = $_POST['id_user'];
  $id_daily_coding = $_POST['id_daily_coding'];
  $api_diperoleh = $_POST['api_diperoleh'];
  $tanggal_perolehan = $_POST['tanggal_perolehan'];

  $sql = "INSERT INTO progres_api (id_user, id_daily_coding, api_diperoleh, tanggal_perolehan) 
            VALUES (:id_user, :id_daily_coding, :api_diperoleh, :tanggal_perolehan)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_daily_coding' => $id_daily_coding,
    ':api_diperoleh' => $api_diperoleh,
    ':tanggal_perolehan' => $tanggal_perolehan
  ]);
}

// Update existing record in progres_api
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_progres_api = $_POST['id_progres_api'];
  $id_user = $_POST['id_user'];
  $id_daily_coding = $_POST['id_daily_coding'];
  $api_diperoleh = $_POST['api_diperoleh'];
  $tanggal_perolehan = $_POST['tanggal_perolehan'];

  $sql = "UPDATE progres_api 
            SET id_user = :id_user, id_daily_coding = :id_daily_coding, api_diperoleh = :api_diperoleh, tanggal_perolehan = :tanggal_perolehan 
            WHERE id_progres_api = :id_progres_api";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_daily_coding' => $id_daily_coding,
    ':api_diperoleh' => $api_diperoleh,
    ':tanggal_perolehan' => $tanggal_perolehan,
    ':id_progres_api' => $id_progres_api
  ]);
}

// Delete record from progres_api
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_progres_api = $_GET['id'];

  $sql = "DELETE FROM progres_api WHERE id_progres_api = :id_progres_api";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_progres_api' => $id_progres_api]);
}

// Fetch all records with JOIN to display related user and daily coding information
$sql = "SELECT progres_api.id_progres_api, user.name AS nama_pengguna, daily_coding.kode_soal, progres_api.api_diperoleh, progres_api.tanggal_perolehan
        FROM progres_api
        JOIN user ON progres_api.id_user = user.id
        JOIN daily_coding ON progres_api.id_daily_coding = daily_coding.id_daily_coding";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SISFO - Progres API</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h3>PROGRES API</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Progres Api</button>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Progres</th>
              <th>Nama Pengguna</th>
              <th>Kode Soal</th>
              <th>API Diperoleh</th>
              <th>Tanggal Perolehan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              foreach ($result as $row) {
                echo "<tr>
                            <td>" . htmlspecialchars($row['id_progres_api']) . "</td>
                            <td>" . htmlspecialchars($row['nama_pengguna']) . "</td>
                            <td>" . htmlspecialchars($row['kode_soal']) . "</td>
                            <td>" . htmlspecialchars($row['api_diperoleh']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_perolehan']) . "</td>
                            <td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_progres_api'] . "'>Edit</button>
                                <a href='?action=delete&id=" . $row['id_progres_api'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>
                        </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal" . $row['id_progres_api'] . "' tabindex='-1'>
                <div class='modal-dialog'>
                  <form method='POST'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Edit Progres</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                      </div>
                      <div class='modal-body'>
                        <input type='hidden' name='id_progres_api' value='" . htmlspecialchars($row['id_progres_api']) . "'>

                        <div class='mb-3'>
                          <label for='id_user' class='form-label'>Nama Pengguna</label>
                          <select class='form-control' name='id_user' required>";

                // Query to get all users
                $sql_users = "SELECT id, name FROM user";
                $stmt_users = $pdo->query($sql_users);
                while ($user = $stmt_users->fetch()) {
                  $selected = ($user['id'] == $row['id_user']) ? "selected" : "";
                  echo "<option value='" . $user['id'] . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                }

                echo "  </select>
                        </div>

                        <div class='mb-3'>
                          <label for='id_daily_coding' class='form-label'>Nama Kegiatan</label>
                          <select class='form-control' name='id_daily_coding' required>";

                // Query to get all daily coding activities
                $sql_kodeSoal = "SELECT id_daily_coding, kode_soal FROM daily_coding";
                $stmt_kodeSoal = $pdo->query($sql_kodeSoal);
                while ($kodeSoal = $stmt_kodeSoal->fetch()) {
                  $selected = ($kodeSoal['id_daily_coding'] == $row['id_daily_coding']) ? "selected" : "";
                  echo "<option value='" . $kodeSoal['id_daily_coding'] . "' $selected>" . htmlspecialchars($kodeSoal['kode_soal']) . "</option>";
                }

                echo "  </select>
                        </div>
                        <div class='mb-3'>
                          <label for='api_diperoleh' class='form-label'>API Diperoleh</label>
                          <input type='number' class='form-control' name='api_diperoleh' value='" . $row['api_diperoleh'] . "' required>
                        </div>

                        <div class='mb-3'>
                          <label for='tanggal_perolehan' class='form-label'>Tanggal Perolehan</label>
                          <input type='date' class='form-control' name='tanggal_perolehan' value='" . $row['tanggal_perolehan'] . "' required>
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

      <!-- Modal Tambah Progres Api-->
      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Progres</h5>
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
                  <label for="id_daily_coding" class="form-label">Kode Soal</label>
                  <select class="form-control" name="id_daily_coding" required>
                    <option value="">Pilih Kode Soal</option>
                    <?php
                    $sql_kodeSoal = "SELECT id_daily_coding, kode_soal FROM daily_coding";
                    $stmt_kodeSoal = $pdo->query($sql_kodeSoal);
                    while ($kodeSoal = $stmt_kodeSoal->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $kodeSoal['id_daily_coding'] . "'>" . $kodeSoal['kode_soal'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="api_diperoleh" class="form-label">API Diperoleh</label>
                  <input type="number" class="form-control" name="api_diperoleh" required>
                </div>
                <div class="mb-3">
                  <label for="tanggal_perolehan" class="form-label">Tanggal Perolehan</label>
                  <input type="date" class="form-control" name="tanggal_perolehan" required>
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

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>