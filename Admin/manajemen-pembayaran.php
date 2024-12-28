<?php
include 'config2.php';

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id = $_POST['id'];
  $id_paket = $_POST['id_paket'];
  $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];
  $bukti_pembayaran = null;

  // Menangani upload file bukti pembayaran
  if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
    // Validasi file gambar
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
      die("Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan untuk bukti pembayaran.");
    }

    // Ambil isi file ke dalam format biner
    $bukti_pembayaran = file_get_contents($file_tmp);
  }

  $sql = "INSERT INTO langganan (id, id_paket, id_metode_pembayaran, tanggal_mulai, tanggal_selesai, bukti_pembayaran) 
          VALUES (:id, :id_paket, :id_metode_pembayaran, :tanggal_mulai, :tanggal_selesai, :bukti_pembayaran)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $id,
    ':id_paket' => $id_paket,
    ':id_metode_pembayaran' => $id_metode_pembayaran,
    ':tanggal_mulai' => $tanggal_mulai,
    ':tanggal_selesai' => $tanggal_selesai,
    ':bukti_pembayaran' => $bukti_pembayaran
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_langganan = $_POST['id_langganan'];
  $id = $_POST['id'];
  $id_paket = $_POST['id_paket'];
  $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
  $tanggal_mulai = $_POST['tanggal_mulai'];
  $tanggal_selesai = $_POST['tanggal_selesai'];
  $bukti_pembayaran = null;

  // Menangani upload file baru untuk bukti pembayaran
  if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
    // Validasi file gambar
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
      die("Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan untuk bukti pembayaran.");
    }

    // Ambil isi file ke dalam format biner
    $bukti_pembayaran = file_get_contents($file_tmp);
  } else {
    // Jika tidak ada file baru yang diunggah, gunakan file yang sudah ada
    $sql_existing = "SELECT bukti_pembayaran FROM langganan WHERE id_langganan = :id_langganan";
    $stmt_existing = $pdo->prepare($sql_existing);
    $stmt_existing->execute([':id_langganan' => $id_langganan]);
    $bukti_pembayaran = $stmt_existing->fetchColumn();
  }

  $sql = "UPDATE langganan 
          SET id = :id, id_paket = :id_paket, id_metode_pembayaran = :id_metode_pembayaran, 
              tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai, bukti_pembayaran = :bukti_pembayaran
          WHERE id_langganan = :id_langganan";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $id,
    ':id_paket' => $id_paket,
    ':id_metode_pembayaran' => $id_metode_pembayaran,
    ':tanggal_mulai' => $tanggal_mulai,
    ':tanggal_selesai' => $tanggal_selesai,
    ':bukti_pembayaran' => $bukti_pembayaran,
    ':id_langganan' => $id_langganan
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_langganan = $_GET['id'];

  $sql = "DELETE FROM langganan WHERE id_langganan = :id_langganan";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_langganan' => $id_langganan]);

  // Redirect untuk mencegah resubmit pada refresh
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// Ambil data untuk tampilan tabel
$sql = "SELECT langganan.id_langganan, user.name AS name_user, paket.nama_paket, paket.harga_paket, 
               metode_pembayaran.nama_metode_pembayaran, langganan.tanggal_mulai, langganan.tanggal_selesai, langganan.bukti_pembayaran
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
              <th>Harga Paket</th>
              <th>Nama Metode Pembayaran</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Bukti Pembayaran</th>
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
        <td>" . htmlspecialchars($row['harga_paket']) . "</td>
        <td>" . htmlspecialchars($row['nama_metode_pembayaran']) . "</td>
        <td>" . date('d/m/Y', strtotime($row['tanggal_mulai'])) . "</td>
        <td>" . date('d/m/Y', strtotime($row['tanggal_selesai'])) . "</td>
        <td>";

                // Cek apakah bukti_pembayaran adalah gambar
                $bukti_pembayaran = $row['bukti_pembayaran']; // Ambil data BLOB
                if ($bukti_pembayaran) {
                  // Base64 encode data gambar untuk ditampilkan
                  $base64_image = base64_encode($bukti_pembayaran);
                  echo "<img src='data:image/jpeg;base64," . $base64_image . "' alt='Bukti Pembayaran' style='width: 100px; height: auto; max-height: 200px; object-fit: contain;'>";
                } else {
                  echo "No image available";
                }

                echo "</td>
        <td>
            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_langganan'] . "'>Edit</button>
            <a href='?action=delete&id=" . $row['id_langganan'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
        </td>
      </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal" . $row['id_langganan'] . "' tabindex='-1'>
<div class='modal-dialog'>
  <form method='POST' enctype='multipart/form-data'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title'>Edit Langganan</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
      </div>
      <div class='modal-body'>
        <input type='hidden' name='id_langganan' value='" . htmlspecialchars($row['id_langganan']) . "'>

        <!-- Nama Pelanggan -->
        <div class='mb-3'>
          <label for='id' class='form-label'>Nama Pelanggan</label>
          <select class='form-control' name='id' required>";
                $sql_user = "SELECT id, name FROM user";
                $stmt_user = $pdo->query($sql_user);
                while ($user = $stmt_user->fetch()) {
                  $selected = ($user['id'] == $row['id']) ? "selected" : "";
                  echo "<option value='" . htmlspecialchars($user['id']) . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                }
                echo "</select>
        </div>

        <!-- Nama Paket -->
        <div class='mb-3'>
          <label for='id_paket' class='form-label'>Paket</label>
          <select class='form-control' name='id_paket' required>";
                $sql_paket = "SELECT id_paket, nama_paket FROM paket";
                $stmt_paket = $pdo->query($sql_paket);
                while ($paket = $stmt_paket->fetch()) {
                  $selected = ($paket['id_paket'] == $row['id_paket']) ? "selected" : "";
                  echo "<option value='" . htmlspecialchars($paket['id_paket']) . "' $selected>" . htmlspecialchars($paket['nama_paket']) . "</option>";
                }
                echo "</select>
        </div>

        <!-- Metode Pembayaran -->
        <div class='mb-3'>
          <label for='id_metode_pembayaran' class='form-label'>Metode Pembayaran</label>
          <select class='form-control' name='id_metode_pembayaran' required>";
                $sql_metode = "SELECT id_metode_pembayaran, nama_metode_pembayaran FROM metode_pembayaran";
                $stmt_metode = $pdo->query($sql_metode);
                while ($metode = $stmt_metode->fetch()) {
                  $selected = ($metode['id_metode_pembayaran'] == $row['id_metode_pembayaran']) ? "selected" : "";
                  echo "<option value='" . htmlspecialchars($metode['id_metode_pembayaran']) . "' $selected>" . htmlspecialchars($metode['nama_metode_pembayaran']) . "</option>";
                }
                echo "</select>
        </div>

        <!-- Tanggal Mulai -->
        <div class='mb-3'>
          <label for='tanggal_mulai' class='form-label'>Tanggal Mulai</label>
          <input type='date' class='form-control' name='tanggal_mulai' value='" . date('Y-m-d', strtotime($row['tanggal_mulai'])) . "' required>
        </div>

        <!-- Tanggal Selesai -->
        <div class='mb-3'>
          <label for='tanggal_selesai' class='form-label'>Tanggal Selesai</label>
          <input type='date' class='form-control' name='tanggal_selesai' value='" . date('Y-m-d', strtotime($row['tanggal_selesai'])) . "' required>
        </div>

        <!-- Bukti Pembayaran -->
        <div class='mb-3'>
          <label for='bukti_pembayaran' class='form-label'>Bukti Pembayaran</label>
          <input type='file' class='form-control' name='bukti_pembayaran' accept='image/*,application/pdf'>
        </div>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
        <button type='submit' name='action' value='update' class='btn btn-primary'>Simpan</button>
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

  <!-- Modal Tambah -->
  <div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Langganan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <!-- Nama Pelanggan -->
            <div class="mb-3">
              <label for="id" class="form-label">Nama Pelanggan</label>
              <select class="form-control" name="id" required>
                <?php
                $sql_user = "SELECT id, name FROM user";
                $stmt_user = $pdo->query($sql_user);
                while ($user = $stmt_user->fetch()) {
                  echo "<option value='" . htmlspecialchars($user['id']) . "'>" . htmlspecialchars($user['name']) . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Nama Paket -->
            <div class="mb-3">
              <label for="id_paket" class="form-label">Paket</label>
              <select class="form-control" name="id_paket" required>
                <?php
                $sql_paket = "SELECT id_paket, nama_paket FROM paket";
                $stmt_paket = $pdo->query($sql_paket);
                while ($paket = $stmt_paket->fetch()) {
                  echo "<option value='" . htmlspecialchars($paket['id_paket']) . "'>" . htmlspecialchars($paket['nama_paket']) . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-3">
              <label for="id_metode_pembayaran" class="form-label">Metode Pembayaran</label>
              <select class="form-control" name="id_metode_pembayaran" required>
                <?php
                $sql_metode = "SELECT id_metode_pembayaran, nama_metode_pembayaran FROM metode_pembayaran";
                $stmt_metode = $pdo->query($sql_metode);
                while ($metode = $stmt_metode->fetch()) {
                  echo "<option value='" . htmlspecialchars($metode['id_metode_pembayaran']) . "'>" . htmlspecialchars($metode['nama_metode_pembayaran']) . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-3">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" name="tanggal_mulai" required>
            </div>

            <!-- Tanggal Selesai -->
            <div class="mb-3">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" name="tanggal_selesai" required>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="mb-3">
              <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
              <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*,application/pdf" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="action" value="create" class="btn btn-primary">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>