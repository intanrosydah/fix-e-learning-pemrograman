<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_kelas = $_POST['id_kelas'];
  $nama_modul = $_POST['nama_modul'];
  $deskripsi_modul = $_POST['deskripsi_modul'];

  $sql = "INSERT INTO modul (id_kelas, nama_modul, deskripsi_modul) 
            VALUES (:id_kelas, :nama_modul, :deskripsi_modul)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_kelas' => $id_kelas,
    ':nama_modul' => $nama_modul,
    ':deskripsi_modul' => $deskripsi_modul
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_modul = $_POST['id_modul'];
  $id_kelas = $_POST['id_kelas'];
  $nama_modul = $_POST['nama_modul'];
  $deskripsi_modul = $_POST['deskripsi_modul'];

  $sql = "UPDATE modul 
            SET id_kelas = :id_kelas, nama_modul = :nama_modul, deskripsi_modul = :deskripsi_modul 
            WHERE id_modul = :id_modul";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_kelas' => $id_kelas,
    ':nama_modul' => $nama_modul,
    ':deskripsi_modul' => $deskripsi_modul,
    ':id_modul' => $id_modul
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_modul = $_GET['id'];

  $sql = "DELETE FROM modul WHERE id_modul = :id_modul";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_modul' => $id_modul]);
}

// Query untuk mendapatkan data modul dengan JOIN
$sql = "SELECT modul.id_modul, modul.nama_modul, modul.deskripsi_modul, kelas.nama_kelas, kelas.id_kelas 
        FROM modul
        JOIN kelas ON modul.id_kelas = kelas.id_kelas
        ORDER BY modul.id_modul ASC";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Modul List</title>
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
        <h3>MODUL KURSUS</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Modul</button>

        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Modul</th>
              <th>Nama Kelas</th>
              <th>Nama Modul</th>
              <th>Deskripsi Modul</th>
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
                echo "<td>" . htmlspecialchars($row['id_modul']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_modul']) . "</td>";
                echo "<td>" . htmlspecialchars($row['deskripsi_modul']) . "</td>";
                echo "<td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_modul'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_modul'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                echo "</tr>";

                // Modal Edit
                echo "
                <div class='modal fade' id='editModal" . $row['id_modul'] . "' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Modul</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_modul' value='" . htmlspecialchars($row['id_modul']) . "'>
                                    <div class='mb-3'>
                                        <label for='id_kelas' class='form-label'>Kelas</label>
                                        <select class='form-select' name='id_kelas' required>
                                            <option value='" . htmlspecialchars($row['id_kelas']) . "' selected>" . htmlspecialchars($row['nama_kelas']) . "</option>
                                            <!-- Tambahkan opsi kelas lain dari database -->
                                        </select>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='nama_modul' class='form-label'>Nama Modul</label>
                                        <input type='text' class='form-control' name='nama_modul' value='" . htmlspecialchars($row['nama_modul']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='deskripsi_modul' class='form-label'>Deskripsi Modul</label>
                                        <textarea class='form-control' name='deskripsi_modul' rows='3' required>" . htmlspecialchars($row['deskripsi_modul']) . "</textarea>
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
                <h5 class="modal-title">Tambah Modul</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id_kelas" class="form-label">Kelas</label>
                  <select class="form-select" name="id_kelas" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    <?php
                    // Query untuk mengambil data kelas
                    $stmt = $pdo->query("SELECT id_kelas, nama_kelas FROM kelas");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . htmlspecialchars($row['id_kelas']) . "'>" . htmlspecialchars($row['nama_kelas']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="nama_modul" class="form-label">Nama Modul</label>
                  <input type="text" class="form-control" name="nama_modul" required>
                </div>
                <div class="mb-3">
                  <label for="deskripsi_modul" class="form-label">Deskripsi Modul</label>
                  <textarea class="form-control" name="deskripsi_modul" rows="3" required></textarea>
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