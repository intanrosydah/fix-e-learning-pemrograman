<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_kategori = $_POST['id_kategori'];
  $nama_kelas = $_POST['nama_kelas'];
  $deskripsi_kelas = $_POST['deskripsi_kelas'];

  $sql = "INSERT INTO kelas (id_kategori, nama_kelas, deskripsi_kelas) 
            VALUES (:id_kategori, :nama_kelas, :deskripsi_kelas)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_kategori' => $id_kategori,
    ':nama_kelas' => $nama_kelas,
    ':deskripsi_kelas' => $deskripsi_kelas
  ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_kelas = $_POST['id_kelas'];
  $id_kategori = $_POST['id_kategori'];
  $nama_kelas = $_POST['nama_kelas'];
  $deskripsi_kelas = $_POST['deskripsi_kelas'];

  $sql = "UPDATE kelas 
            SET id_kategori = :id_kategori, nama_kelas = :nama_kelas, deskripsi_kelas = :deskripsi_kelas 
            WHERE id_kelas = :id_kelas";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_kategori' => $id_kategori,
    ':nama_kelas' => $nama_kelas,
    ':deskripsi_kelas' => $deskripsi_kelas,
    ':id_kelas' => $id_kelas
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_kelas = $_GET['id'];

  $sql = "DELETE FROM kelas WHERE id_kelas = :id_kelas";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_kelas' => $id_kelas]);
}

// Query untuk mendapatkan data dengan JOIN
$sql = "SELECT kelas.id_kelas, kelas.nama_kelas, kelas.deskripsi_kelas, kategori.nama_kategori, kategori.id_kategori 
        FROM kelas
        JOIN kategori ON kelas.id_kategori = kategori.id_kategori
        ORDER BY kelas.id_kelas ASC";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISFO - Mata Kuliah List</title>
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
        <h3>KELAS KURSUS</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kelas</button>
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
              <th>ID Kelas</th> <!-- Mengubah dari ID Materi ke ID Kelas -->
              <th>Nama Kategori</th>
              <th>Nama Kelas</th> <!-- Mengubah dari Nama Materi ke Nama Kelas -->
              <th>Deskripsi Kelas</th>
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
                echo "<td>" . htmlspecialchars($row['id_kelas']) . "</td>"; // ID Kelas dari database
                echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>"; // Nama Kelas dari database
                echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>"; // Nama Kelas dari database
                echo "<td>" . htmlspecialchars($row['deskripsi_kelas']) . "</td>"; // Nama Kelas dari database
                echo "<td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_kelas'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_kelas'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                echo "</tr>";

                // Modal Edit
                echo "
                <div class='modal fade' id='editModal" . $row['id_kelas'] . "' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Kelas</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_kelas' value='" . htmlspecialchars($row['id_kelas']) . "'>
                                    <div class='mb-3'>
                                        <label for='id_kategori' class='form-label'>Kategori</label>
                                        <select class='form-select' name='id_kategori' required>
                                            <option value='" . htmlspecialchars($row['id_kategori']) . "' selected>" . htmlspecialchars($row['nama_kategori']) . "</option>
                                            <!-- Tambahkan opsi kategori lain dari database -->
                                        </select>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='nama_kelas' class='form-label'>Nama Kelas</label>
                                        <input type='text' class='form-control' name='nama_kelas' value='" . htmlspecialchars($row['nama_kelas']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='deskripsi_kelas' class='form-label'>Deskripsi</label>
                                        <textarea class='form-control' name='deskripsi_kelas' rows='3' required>" . htmlspecialchars($row['deskripsi_kelas']) . "</textarea>
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
                <h5 class="modal-title">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id_kategori" class="form-label">Kategori</label>
                  <select class="form-select" name="id_kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php
                    // Query untuk mengambil data kategori
                    $stmt = $pdo->query("SELECT id_kategori, nama_kategori FROM kategori");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      echo "<option value='" . htmlspecialchars($row['id_kategori']) . "'>" . htmlspecialchars($row['nama_kategori']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="nama_kelas" class="form-label">Nama Kelas</label>
                  <input type="text" class="form-control" name="nama_kelas" required>
                </div>
                <div class="mb-3">
                  <label for="deskripsi_kelas" class="form-label">Deskripsi Kelas</label>
                  <textarea class="form-control" name="deskripsi_kelas" rows="3" required></textarea>
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