<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data Bab
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_modul = $_POST['id_modul'];
    $nama_bab = $_POST['nama_bab'];
    $konten_bab = $_POST['konten_bab'];

    $sql = "INSERT INTO bab (id_modul, nama_bab, konten_bab) 
            VALUES (:id_modul, :nama_bab, :konten_bab)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_modul' => $id_modul,
        ':nama_bab' => $nama_bab,
        ':konten_bab' => $konten_bab
    ]);
}

// Proses Update Data Bab
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_bab = $_POST['id_bab'];
    $id_modul = $_POST['id_modul'];
    $nama_bab = $_POST['nama_bab'];
    $konten_bab = $_POST['konten_bab'];

    $sql = "UPDATE bab 
            SET id_modul = :id_modul, nama_bab = :nama_bab, konten_bab = :konten_bab 
            WHERE id_bab = :id_bab";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_modul' => $id_modul,
        ':nama_bab' => $nama_bab,
        ':konten_bab' => $konten_bab,
        ':id_bab' => $id_bab
    ]);
}

// Proses Hapus Data Bab
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_bab = $_GET['id'];

    $sql = "DELETE FROM bab WHERE id_bab = :id_bab";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_bab' => $id_bab]);
}

// Query untuk mendapatkan data bab dengan JOIN
$sql = "SELECT bab.id_bab, bab.nama_bab, bab.konten_bab, modul.nama_modul, modul.id_modul 
        FROM bab
        JOIN modul ON bab.id_modul = modul.id_modul
        ORDER BY bab.id_bab ASC";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Bab</title>
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
                <h3>DAFTAR BAB</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Bab</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Bab</th>
                            <th>Nama Modul</th>
                            <th>Nama Bab</th>
                            <th>Konten Bab</th>
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
                                echo "<td>" . htmlspecialchars($row['id_bab']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_modul']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_bab']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['konten_bab']) . "</td>";
                                echo "<td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_bab'] . "'>Edit</button>
                          <a href='?action=delete&id=" . $row['id_bab'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                <div class='modal fade' id='editModal" . $row['id_bab'] . "' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Bab</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_bab' value='" . htmlspecialchars($row['id_bab']) . "'>
                                    <div class='mb-3'>
                                        <label for='id_modul' class='form-label'>Modul</label>
                                        <select class='form-select' name='id_modul' required>
                                            <option value='" . htmlspecialchars($row['id_modul']) . "' selected>" . htmlspecialchars($row['nama_modul']) . "</option>
                                            <!-- Tambahkan opsi modul lain dari database -->
                                        </select>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='nama_bab' class='form-label'>Nama Bab</label>
                                        <input type='text' class='form-control' name='nama_bab' value='" . htmlspecialchars($row['nama_bab']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='konten_bab' class='form-label'>Konten Bab</label>
                                        <textarea class='form-control' name='konten_bab' rows='3' required>" . htmlspecialchars($row['konten_bab']) . "</textarea>
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

            <!-- Modal Tambah Data Bab -->
            <div class="modal fade" id="addModal" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Bab</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_modul" class="form-label">Modul</label>
                                    <select class="form-select" name="id_modul" required>
                                        <option value="" disabled selected>Pilih Modul</option>
                                        <?php
                                        // Query untuk mengambil data modul
                                        $stmt = $pdo->query("SELECT id_modul, nama_modul FROM modul");
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . htmlspecialchars($row['id_modul']) . "'>" . htmlspecialchars($row['nama_modul']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_bab" class="form-label">Nama Bab</label>
                                    <input type="text" class="form-control" name="nama_bab" required>
                                </div>
                                <div class="mb-3">
                                    <label for="konten_bab" class="form-label">Konten Bab</label>
                                    <textarea class="form-control" name="konten_bab" rows="3" required></textarea>
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