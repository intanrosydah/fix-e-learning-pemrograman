<?php
include 'config2.php'; // Database connection file

// Add new record to progres_kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_user = $_POST['id_user'];
  $id_kelas = $_POST['id_kelas'];
  $status = $_POST['status'];
  $tanggal_selesai = $_POST['tanggal_selesai'];
  $skor_akhir = $_POST['skor_akhir'];

  $sql = "INSERT INTO progres_kelas (id, id_kelas, status, tanggal_selesai, skor_akhir) 
            VALUES (:id_user, :id_kelas, :status, :tanggal_selesai, :skor_akhir)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_kelas' => $id_kelas,
    ':status' => $status,
    ':tanggal_selesai' => $tanggal_selesai,
    ':skor_akhir' => $skor_akhir
  ]);
}

// Update existing record in progres_kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_progres = $_POST['id_progres'];
  $id_user = $_POST['id_user'];
  $id_kelas = $_POST['id_kelas'];
  $status = $_POST['status'];
  $tanggal_selesai = $_POST['tanggal_selesai'];
  $skor_akhir = $_POST['skor_akhir'];

  $sql = "UPDATE progres_kelas 
            SET id = :id_user, id_kelas = :id_kelas, status = :status, tanggal_selesai = :tanggal_selesai, skor_akhir = :skor_akhir 
            WHERE id_progres = :id_progres";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_kelas' => $id_kelas,
    ':status' => $status,
    ':tanggal_selesai' => $tanggal_selesai,
    ':skor_akhir' => $skor_akhir,
    ':id_progres' => $id_progres
  ]);
}

// Delete record from progres_kelas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_progres = $_GET['id'];

  $sql = "DELETE FROM progres_kelas WHERE id_progres = :id_progres";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_progres' => $id_progres]);
}

// Fetch all records with JOIN to display related user and class information
$sql = "SELECT progres_kelas.id_progres, user.name AS nama_pengguna, kelas.nama_kelas, progres_kelas.status, progres_kelas.tanggal_selesai, progres_kelas.skor_akhir
        FROM progres_kelas
        JOIN user ON progres_kelas.id = user.id
        JOIN kelas ON progres_kelas.id_kelas = kelas.id_kelas";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SISFO - Monitoring Aktivitas</title>
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
        <h3>MONITORING AKTIVITAS</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Progres</button>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Progres</th>
              <th>Nama Pengguna</th>
              <th>Nama Kelas</th>
              <th>Status</th>
              <th>Tanggal Selesai</th>
              <th>Skor Akhir</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              foreach ($result as $row) {
                echo "<tr>
                            <td>" . htmlspecialchars($row['id_progres']) . "</td>
                            <td>" . htmlspecialchars($row['nama_pengguna']) . "</td>
                            <td>" . htmlspecialchars($row['nama_kelas']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_selesai']) . "</td>
                            <td>" . htmlspecialchars($row['skor_akhir']) . "</td>
                            <td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_progres'] . "'>Edit</button>
                                <a href='?action=delete&id=" . $row['id_progres'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>
                        </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal" . $row['id_progres'] . "' tabindex='-1'>
                <div class='modal-dialog'>
                  <form method='POST'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Edit Progres</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                      </div>
                      <div class='modal-body'>
                        <input type='hidden' name='id_progres' value='" . htmlspecialchars($row['id_progres']) . "'>

                        <div class='mb-3'>
                          <label for='id_user' class='form-label'>Nama Pengguna</label>
                          <select class='form-control' name='id_user' required>";

                // Query to get all users
                $sql_users = "SELECT id, name FROM user";
                $stmt_users = $pdo->query($sql_users);
                while ($user = $stmt_users->fetch()) {
                  $selected = ($user['id'] == $row['id']) ? "selected" : "";
                  echo "<option value='" . $user['id'] . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                }

                echo "  </select>
                        </div>

                        <div class='mb-3'>
                          <label for='id_kelas' class='form-label'>Nama Kelas</label>
                          <select class='form-control' name='id_kelas' required>";

                // Query to get all classes
                $sql_kelas = "SELECT id_kelas, nama_kelas FROM kelas";
                $stmt_kelas = $pdo->query($sql_kelas);
                while ($kelas = $stmt_kelas->fetch()) {
                  $selected = ($kelas['id_kelas'] == $row['id_kelas']) ? "selected" : "";
                  echo "<option value='" . $kelas['id_kelas'] . "' $selected>" . htmlspecialchars($kelas['nama_kelas']) . "</option>";
                }

                echo "  </select>
                        </div>
                        <div class='mb-3'>
                          <label for='status' class='form-label'>Status</label>
                          <select class='form-control' name='status' required>
                            <option value='dipilih' " . ($row['status'] === 'dipilih' ? 'selected' : '') . ">Dipilih</option>
                            <option value='dipelajari' " . ($row['status'] === 'dipelajari' ? 'selected' : '') . ">Dipelajari</option>
                            <option value='diselesaikan' " . ($row['status'] === 'diselesaikan' ? 'selected' : '') . ">Diselesaikan</option>
                          </select>
                        </div>

                        <div class='mb-3'>
                          <label for='tanggal_selesai' class='form-label'>Tanggal Selesai</label>
                          <input type='date' class='form-control' name='tanggal_selesai' value='" . $row['tanggal_selesai'] . "'>
                        </div>

                        <div class='mb-3'>
                          <label for='skor_akhir' class='form-label'>Skor Akhir</label>
                          <input type='number' class='form-control' name='skor_akhir' value='" . $row['skor_akhir'] . "' required>
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

      <!-- Modal Tambah Aktivitas -->
      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id" class="form-label">Nama Pengguna</label>
                  <select class="form-control" name="id" required>
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
                  <label for="id_kelas" class="form-label">Nama Kelas</label>
                  <select class="form-control" name="id_kelas" required>
                    <option value="">Pilih Nama Kelas</option>
                    <?php
                    $sql_kelas = "SELECT id_kelas, nama_kelas FROM kelas";
                    $stmt_kelas = $pdo->query($sql_kelas);
                    while ($kelas = $stmt_kelas->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $kelas['id_kelas'] . "'>" . $kelas['nama_kelas'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <input type="text" class="form-control" name="status" required>
                </div>
                <div class="mb-3">
                  <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                  <input type="datetime-local" class="form-control" name="tanggal_selesai" required>
                </div>
                <div class="mb-3">
                  <label for="skor_akhir" class="form-label">Skor Akhir</label>
                  <input type="number" class="form-control" name="skor_akhir" required>
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