<?php
// Menghubungkan ke database menggunakan PDO
include 'config2.php'; // Dianggap sudah ada konfigurasi PDO pada file ini

// Query untuk data progres (ditempatkan di atas)
$sql_progres = "SELECT id_progres, CONCAT(user.name, ' - ', kelas.nama_kelas) AS progres
                FROM progres_kelas
                JOIN user ON progres_kelas.id = user.id
                JOIN kelas ON progres_kelas.id_kelas = kelas.id_kelas";
$stmt_progres = $pdo->query($sql_progres);
$progres_options = $stmt_progres->fetchAll(PDO::FETCH_ASSOC);

// Proses Tambah Data Sertifikat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  $id_progres = $_POST['id_progres']; // ID progres dari tabel progres_kelas
  $tanggal_terbit = $_POST['tanggal_terbit'];
  $gambar_sertifikat = null;

  // Menangani upload file gambar sertifikat
  if (isset($_FILES['gambar_sertifikat']) && $_FILES['gambar_sertifikat']['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_tmp = $_FILES['gambar_sertifikat']['tmp_name'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
      die("Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.");
    }

    $gambar_sertifikat = file_get_contents($file_tmp);
  }

  // Menyimpan data sertifikat
  $sql = "INSERT INTO sertifikat (id_progres, tanggal_terbit, gambar_sertifikat) 
          VALUES (:id_progres, :tanggal_terbit, :gambar_sertifikat)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_progres' => $id_progres,
    ':tanggal_terbit' => $tanggal_terbit,
    ':gambar_sertifikat' => $gambar_sertifikat
  ]);
}

// Proses Update Data Sertifikat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
  $id_sertifikat = $_POST['id_sertifikat'];
  $id_progres = $_POST['id_progres'];
  $tanggal_terbit = $_POST['tanggal_terbit'];
  $gambar_sertifikat = null;

  // Menangani upload file baru
  if (isset($_FILES['gambar_sertifikat']) && $_FILES['gambar_sertifikat']['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_tmp = $_FILES['gambar_sertifikat']['tmp_name'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
      die("Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.");
    }

    $gambar_sertifikat = file_get_contents($file_tmp);
  } else {
    // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
    $sql_existing = "SELECT gambar_sertifikat FROM sertifikat WHERE id_sertifikat = :id_sertifikat";
    $stmt_existing = $pdo->prepare($sql_existing);
    $stmt_existing->execute([':id_sertifikat' => $id_sertifikat]);
    $gambar_sertifikat = $stmt_existing->fetchColumn();
  }

  // Update data sertifikat
  $sql = "UPDATE sertifikat 
          SET id_progres = :id_progres, tanggal_terbit = :tanggal_terbit, 
              gambar_sertifikat = :gambar_sertifikat
          WHERE id_sertifikat = :id_sertifikat";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id_progres' => $id_progres,
    ':tanggal_terbit' => $tanggal_terbit,
    ':gambar_sertifikat' => $gambar_sertifikat,
    ':id_sertifikat' => $id_sertifikat
  ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
  $id_sertifikat = $_GET['id_sertifikat'];

  $sql = "DELETE FROM sertifikat WHERE id_sertifikat = :id_sertifikat";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id_sertifikat' => $id_sertifikat]);

  // Redirect untuk mencegah resubmit
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// Mendapatkan Data Sertifikat dan Menampilkan Nama Pengguna dan Kelas
$sql_sertifikat = "SELECT sertifikat.id_sertifikat, sertifikat.id_progres, sertifikat.tanggal_terbit, sertifikat.gambar_sertifikat, 
                          user.name AS name_user, kelas.nama_kelas
                   FROM sertifikat 
                   JOIN progres_kelas  ON sertifikat.id_progres = progres_kelas.id_progres
                   JOIN user ON progres_kelas.id = user.id
                   JOIN kelas ON progres_kelas.id_kelas = kelas.id_kelas
                   ORDER BY sertifikat.id_sertifikat ASC";
$result = $pdo->query($sql_sertifikat);
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



    .table img {
      max-width: 100%;
      max-height: 150px;
      /* Adjust as needed */
      height: auto;

      object-fit: contain;
    }

    th,
    td {
      white-space: nowrap;
      padding: 10px;
      /* Prevent text wrapping */
    }

    td img {
      max-width: 200px;
      /* Adjust based on your needs */
      height: auto;
      object-fit: contain;
      /* Ensures that image will not be cropped */
      display: block;
      /* Prevents image from being distorted */
      margin: 0 auto;
      /* Centers the image inside the cell */
    }
  </style>
</head>

<body>
  <?php require 'sidebar.php'; ?>

  <!-- Main Content -->
  <div class="content pt-5 mt-3">
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>MANAJEMEN SERTIFIKAT</h3>
        <div>
          <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Sertifikat</button>
          <button class="btn btn-primary me-2" onclick="exportToExcel()">Excel</button>
          <button class="btn btn-primary me-2" onclick="exportToWord()">Word</button>
          <button class="btn btn-primary" onclick="exportToPDF()">PDF</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Sertifikat</th>
              <th>Nama User</th>
              <th>Nama Kelas</th>
              <th>Tanggal Terbit</th>
              <th>Gambar Sertifikat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result) {
              $no = 1;
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
        <td>" . htmlspecialchars($no) . "</td>
        <td>" . htmlspecialchars($row['id_sertifikat']) . "</td>
        <td>" . htmlspecialchars($row['name_user']) . "</td>
        <td>" . htmlspecialchars($row['nama_kelas']) . "</td>
        <td>" . htmlspecialchars($row['tanggal_terbit']) . "</td>
        <td>";

                // Cek apakah gambar_sertifikat adalah nama file atau data gambar
                $gambar_sertifikat = $row['gambar_sertifikat']; // Ambil data BLOB
                if ($gambar_sertifikat) {
                  // Base64 encode data gambar untuk ditampilkan
                  $base64_image = base64_encode($gambar_sertifikat);
                  echo "<img src='data:image/jpeg;base64," . $base64_image . "' alt='Sertifikat' style='max-width: 100%; height: auto; object-fit: contain;'>";
                } else {
                  echo "No image available";
                }

                echo "</td>
        <td>
            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . htmlspecialchars($row['id_sertifikat']) . "'>Edit</button>
            <a href='?action=delete&id=" . htmlspecialchars($row['id_sertifikat']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
        </td>
      </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='editModal{$row['id_sertifikat']}' tabindex='-1'>
              <div class='modal-dialog'>
                <form method='POST' enctype='multipart/form-data'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title'>Edit Sertifikat</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                      <input type='hidden' name='id_sertifikat' value='{$row['id_sertifikat']}'>

                      <!-- Progres -->
                    <div class='mb-3'>
                        <label for='id_progres' class='form-label'>Progres</label>
                        <select class='form-select' name='id_progres' required>
                            <option value=''>Pilih Progres</option>";

                foreach ($progres_options as $progres) {
                  $selected = ($row['id_progres'] == $progres['id_progres']) ? 'selected' : '';
                  echo "<option value='" . htmlspecialchars($progres['id_progres']) . "' $selected>"
                    . htmlspecialchars($progres['progres']) . "</option>";
                }

                echo "</select>
                    </div>

                      <!-- Tanggal Terbit -->
                      <div class='mb-3'>
                        <label for='tanggal_terbit' class='form-label'>Tanggal Terbit</label>
                        <input type='date' class='form-control' name='tanggal_terbit' value='{$row['tanggal_terbit']}' required>
                      </div>

                      <!-- Gambar Sertifikat -->
                      <div class='mb-3'>
                        <label for='gambar_sertifikat' class='form-label'>Gambar Sertifikat</label>
                        <input type='file' class='form-control' name='gambar_sertifikat' accept='image/*'>
                      </div>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                      <button type='submit' name='action' value='update' class='btn btn-primary'>Save Changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>";

                $no++;
              }
            } else {
              echo "<tr><td colspan='8'>No data available</td></tr>";
            }
            ?>
          </tbody>

        </table>
      </div>

      <!-- Modal Tambah Sertifikat -->
      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="id_progres" class="form-label">Progres</label>
                  <select class="form-control" name="id_progres" required>
                    <?php
                    $sql_progres = "SELECT id_progres, CONCAT(user.name, ' - ', kelas.nama_kelas) AS progres
                    FROM progres_kelas
                    JOIN user ON progres_kelas.id = user.id
                    JOIN kelas ON progres_kelas.id_kelas = kelas.id_kelas";
                    $stmt_progres = $pdo->query($sql_progres);
                    while ($progres = $stmt_progres->fetch()) {
                      echo "<option value='" . htmlspecialchars($progres['id_progres']) . "'>" . htmlspecialchars($progres['progres']) . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <!-- Tanggal Terbit -->
                <div class="mb-3">
                  <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                  <input type="date" class="form-control" name="tanggal_terbit" required>
                </div>

                <!-- Gambar Sertifikat -->
                <div class="mb-3">
                  <label for="gambar_sertifikat" class="form-label">Gambar Sertifikat</label>
                  <input type="file" class="form-control" name="gambar_sertifikat" accept="image/*" required>
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
  <!-- Excel Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

  <!-- PDF Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <!-- Word Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html-docx-js/0.7.3/html-docx.js"></script>

  <script>
    // Export to Excel
    function exportToExcel() {
      const table = document.querySelector('table');
      const wb = XLSX.utils.table_to_book(table, {
        sheet: "Sheet 1"
      });
      XLSX.writeFile(wb, 'SertifikatData.xlsx');
    }

    // Export to PDF
    function exportToPDF() {
      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF();
      doc.html(document.querySelector('.table-responsive'), {
        callback: function(doc) {
          doc.save('SertifikatData.pdf');
        },
        margin: [10, 10, 10, 10]
      });
    }

    // Export to Word
    function exportToWord() {
      const table = document.querySelector('table');
      const html = table.outerHTML;
      const converted = htmlDocx.asBlob(html);
      const link = document.createElement('a');
      link.href = URL.createObjectURL(converted);
      link.download = 'SertifikatData.docx';
      link.click();
    }
  </script>

</body>

</html>