<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_user = $_POST['id_user'];
  $id_paket = $_POST['id_paket'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];

  $sql = "INSERT INTO langganan (id_user, id_paket, tanggal_mulai, tanggal_selesai) 
            VALUES (:id_user, :id_paket, :tanggal_mulai, :tanggal_selesai)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_paket' => $id_paket,
    ':tanggal_mulai' => $tanggal_mulai,
    ':tanggal_selesai' => $tanggal_selesai
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_langganan = $_POST['id_langganan'];
  $id_user = $_POST['id_user'];
  $id_paket = $_POST['id_paket'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];

  $sql = "UPDATE langganan 
            SET id_user = :id_user, id_paket = :id_paket, tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai 
            WHERE id_langganan = :id_langganan";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_user' => $id_user,
    ':id_paket' => $id_paket,
    ':tanggal_mulai' => $tanggal_mulai,
    ':tanggal_selesai' => $tanggal_selesai,
    ':id_langganan' => $id_langganan
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_langganan = $_GET['id'];

  $sql = "DELETE FROM langganan WHERE id_langganan = :id_langganan";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_langganan' => $id_langganan]);
}

// Query untuk mendapatkan data dengan JOIN
$sql = "SELECT langganan.id_langganan, user.name AS nama_pengguna, paket.nama_paket, langganan.tanggal_mulai, langganan.tanggal_selesai
        FROM langganan
        JOIN user ON langganan.id = user.id
        JOIN paket ON langganan.id_paket = paket.id_paket";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Langganan List</title>
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
        <h3>JADWAL KURSUS</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Langganan</button>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Langganan</th>
              <th>Nama Pengguna</th>
              <th>Nama Paket</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              foreach ($result as $row) {
                $status = (strtotime($row['tanggal_selesai']) < time()) ? 'Selesai' : 'Aktif';
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_langganan']) . "</td>
                        <td>" . htmlspecialchars($row['nama_pengguna']) . "</td>
                        <td>" . htmlspecialchars($row['nama_paket']) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['tanggal_mulai'])) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['tanggal_selesai'])) . "</td>
                        <td>" . $status . "</td>
                        <td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_langganan'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_langganan'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>
                      </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal" . $row['id_langganan'] . "' tabindex='-1'>
                        <div class='modal-dialog'>
                          <form method='POST'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h5 class='modal-title'>Edit Langganan</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                              </div>
                              <div class='modal-body'>
                                <input type='hidden' name='id_langganan' value='" . htmlspecialchars($row['id_langganan']) . "'>

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
                                              <label for='id_paket' class='form-label'>Nama Paket</label>
                                              <select class='form-control' name='id_paket' required>";

                // Query to get all packages
                $sql_packages = "SELECT id_paket, nama_paket FROM paket";
                $stmt_packages = $pdo->query($sql_packages);
                while ($package = $stmt_packages->fetch()) {
                  $selected = ($package['id_paket'] == $row['id_paket']) ? "selected" : "";
                  echo "<option value='" . $package['id_paket'] . "' $selected>" . htmlspecialchars($package['nama_paket']) . "</option>";
                }

                echo "  </select>
                                            </div>

                        <div class='mb-3'>
                          <label for='tanggal_mulai' class='form-label'>Tanggal Mulai</label>
                          <input type='date' class='form-control' name='tanggal_mulai' value='" . $row['tanggal_mulai'] . "' required>
                        </div>
                        <div class='mb-3'>
                          <label for='tanggal_selesai' class='form-label'>Tanggal Selesai</label>
                          <input type='date' class='form-control' name='tanggal_selesai' value='" . $row['tanggal_selesai'] . "' required>
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

      <!-- Modal Tambah Langganan -->
      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Langganan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id_user" class="form-label">Nama Pengguna</label>
                  <select class="form-control" name="id_user" required>
                    <option value="">Pilih Nama Pengguna</option>
                    <?php
                    // Query untuk mengambil data pengguna
                    $sql_user = "SELECT id, name FROM user";
                    $stmt_user = $pdo->query($sql_user);
                    while ($user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $user['id'] . "'>" . $user['name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="id_paket" class="form-label">Nama Paket</label>
                  <select class="form-control" name="id_paket" required>
                    <option value="">Pilih Nama Paket</option>
                    <?php
                    // Query untuk mengambil data paket
                    $sql_paket = "SELECT id_paket, nama_paket FROM paket";
                    $stmt_paket = $pdo->query($sql_paket);
                    while ($paket = $stmt_paket->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . $paket['id_paket'] . "'>" . $paket['nama_paket'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                  <input type="date" class="form-control" name="tanggal_mulai" required>
                </div>
                <div class="mb-3">
                  <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                  <input type="date" class="form-control" name="tanggal_selesai" required>
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