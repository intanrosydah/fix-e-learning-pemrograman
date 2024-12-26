<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
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

// Proses Update Data
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

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_progres_api = $_GET['id'];

  $sql = "DELETE FROM progres_api WHERE id_progres_api = :id_progres_api";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_progres_api' => $id_progres_api]);
}

// Query untuk mendapatkan data dengan JOIN
$sql = "SELECT progres_api.id_progres_api, user.name AS nama_pengguna, daily_coding.deskrpsi_tantangan, progres_api.api_diperoleh, progres_api.tanggal_perolehan
        FROM progres_api
        JOIN user ON progres_api.id_user = user.id
        JOIN daily_coding ON progres_api.id_daily_coding = daily_coding.id_daily_coding";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Progress API</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5">
    <h3>Progress API</h3>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID Progress</th>
          <th>Nama Pengguna</th>
          <th>Deskripsi Tantangan</th>
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
                    <td>" . htmlspecialchars($row['deskrpsi_tantangan']) . "</td>
                    <td>" . htmlspecialchars($row['api_diperoleh']) . "</td>
                    <td>" . htmlspecialchars($row['tanggal_perolehan']) . "</td>
                    <td>
                      <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_progres_api'] . "'>Edit</button>
                      <a href='?action=delete&id=" . $row['id_progres_api'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>
                  </tr>";
          }
        }
        ?>
      </tbody>
    </table>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data Progress</h5>
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
                  while ($user = $stmt_user->fetch()) {
                    echo "<option value='" . $user['id'] . "'>" . htmlspecialchars($user['name']) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_daily_coding" class="form-label">Deskripsi Tantangan</label>
                <select class="form-control" name="id_daily_coding" required>
                  <option value="">Pilih Tantangan</option>
                  <?php
                  $sql_challenges = "SELECT id_daily_coding, deskrpsi_tantangan FROM daily_coding";
                  $stmt_challenges = $pdo->query($sql_challenges);
                  while ($challenge = $stmt_challenges->fetch()) {
                    echo "<option value='" . $challenge['id_daily_coding'] . "'>" . htmlspecialchars($challenge['deskrpsi_tantangan']) . "</option>";
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
