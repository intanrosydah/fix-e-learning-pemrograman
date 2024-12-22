<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id = $_POST['id'];
  $id_paket = $_POST['id_paket'];
  $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
  $nomor_va = $_POST['nomor_va'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];

  $sql = "INSERT INTO langganan (id, id_paket, id_metode_pembayaran, nomor_va, tanggal_mulai, tanggal_selesai) 
            VALUES (:id, :id_paket, :id_metode_pembayaran, :nomor_va, :tanggal_mulai, :tanggal_selesai)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $id,
    ':id_paket' => $id_paket,
    ':id_metode_pembayaran' => $id_metode_pembayaran,
    ':nomor_va' => $nomor_va,
    ':tanggal_mulai' => $tanggal_mulai,
    ':tanggal_selesai' => $tanggal_selesai
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_langganan = $_POST['id_langganan'];
  $id = $_POST['id'];
  $id_paket = $_POST['id_paket'];
  $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
  $nomor_va = $_POST['nomor_va'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];

  $sql = "UPDATE langganan 
            SET id = :id, id_paket = :id_paket, id_metode_pembayaran = :id_metode_pembayaran, nomor_va = :nomor_va, 
                tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai 
            WHERE id_langganan = :id_langganan";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $id,
    ':id_paket' => $id_paket,
    ':id_metode_pembayaran' => $id_metode_pembayaran,
    ':nomor_va' => $nomor_va,
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
$sql = "SELECT langganan.id_langganan, user.name AS name_user, paket.nama_paket, metode_pembayaran.nama_metode_pembayaran, langganan.nomor_va, langganan.tanggal_mulai, langganan.tanggal_selesai
        FROM langganan
        JOIN user ON langganan.id = user.id
        JOIN paket ON langganan.id_paket = paket.id_paket
        JOIN metode_pembayaran ON langganan.id_metode_pembayaran = metode_pembayaran.id_metode_pembayaran
        ORDER BY langganan.id_langganan ASC";
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
  <?php require 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="content pt-5 mt-3">
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>RIWAYAT LANGGANAN</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Langganan</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Langganan</th>
              <th>Nama Pelanggan</th>
              <th>Nama Paket</th>
              <th>Nama Metode Pembayaran</th>
              <th>Nomor VA</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              foreach ($result as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_langganan']) . "</td>
                        <td>" . htmlspecialchars($row['name_user']) . "</td>
                        <td>" . htmlspecialchars($row['nama_paket']) . "</td>
                        <td>" . htmlspecialchars($row['nama_metode_pembayaran']) . "</td>
                        <td>" . htmlspecialchars($row['nomor_va']) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['tanggal_mulai'])) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['tanggal_selesai'])) . "</td>
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
                                  <label for='id' class='form-label'>Nama Pelanggan</label>
                                  <select class='form-control' name='id' required>";

                // Query untuk mengambil pelanggan
                $sql_user = "SELECT id, name FROM user";
                $stmt_user = $pdo->query($sql_user);
                while ($user = $stmt_user->fetch()) {
                  $selected = ($user['id'] == $row['id']) ? "selected" : "";
                  echo "<option value='" . $user['id'] . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                }

                echo "</select></div>
                      <div class='mb-3'>
                        <label for='id_paket' class='form-label'>Nama Paket</label>
                        <select class='form-control' name='id_paket' required>";

                // Query untuk mengambil paket
                $sql_paket = "SELECT id_paket, nama_paket FROM paket";
                $stmt_paket = $pdo->query($sql_paket);
                while ($paket = $stmt_paket->fetch()) {
                  $selected = ($paket['id_paket'] == $row['id_paket']) ? "selected" : "";
                  echo "<option value='" . $paket['id_paket'] . "' $selected>" . $paket['nama_paket'] . "</option>";
                }

                echo "</select></div>
                      <div class='mb-3'>
                        <label for='id_metode_pembayaran' class='form-label'>Nama Metode Pembayaran</label>
                        <select class='form-control' name='id_metode_pembayaran' required>";

                // Query untuk mengambil metode pembayaran
                $sql_metode = "SELECT id_metode_pembayaran, nama_metode_pembayaran FROM metode_pembayaran";
                $stmt_metode = $pdo->query($sql_metode);
                while ($metode = $stmt_metode->fetch()) {
                  $selected = ($metode['id_metode_pembayaran'] == $row['id_metode_pembayaran']) ? "selected" : "";
                  echo "<option value='" . $metode['id_metode_pembayaran'] . "' $selected>" . $metode['nama_metode_pembayaran'] . "</option>";
                }

                echo "</select></div>
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
    </div>
  </div>

  <!-- Modal Tambah Langganan -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Tambah Langganan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="id" class="form-label">Nama Pelanggan</label>
              <select class="form-control" name="id" required>
                <?php
                $stmt_user = $pdo->query("SELECT id, name FROM user");
                while ($user = $stmt_user->fetch()) {
                  echo "<option value='" . $user['id'] . "'>" . htmlspecialchars($user['name']) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="id_paket" class="form-label">Nama Paket</label>
              <select class="form-control" name="id_paket" required>
                <?php
                $stmt_paket = $pdo->query("SELECT id_paket, nama_paket FROM paket");
                while ($paket = $stmt_paket->fetch()) {
                  echo "<option value='" . $paket['id_paket'] . "'>" . $paket['nama_paket'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="id_metode_pembayaran" class="form-label">Metode Pembayaran</label>
              <select class="form-control" name="id_metode_pembayaran" required>
                <?php
                $stmt_metode = $pdo->query("SELECT id_metode_pembayaran, nama_metode_pembayaran FROM metode_pembayaran");
                while ($metode = $stmt_metode->fetch()) {
                  echo "<option value='" . $metode['id_metode_pembayaran'] . "'>" . htmlspecialchars($metode['nama_metode_pembayaran']) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="nomor_va" class="form-label">Nomor VA</label>
              <input type="text" class="form-control" name="nomor_va" required>
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


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>