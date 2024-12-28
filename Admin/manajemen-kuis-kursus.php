<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data Kuis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_modul = $_POST['id_modul'];
    $nama_kuis = $_POST['nama_kuis'];
    $deskripsi_kuis = $_POST['deskripsi_kuis'];

    $sql = "INSERT INTO kuis (id_modul, nama_kuis, deskripsi_kuis) 
            VALUES (:id_modul, :nama_kuis, :deskripsi_kuis)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_modul' => $id_modul,
        ':nama_kuis' => $nama_kuis,
        ':deskripsi_kuis' => $deskripsi_kuis
    ]);
}

// Proses Update Data Kuis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_kuis = $_POST['id_kuis'];
    $id_modul = $_POST['id_modul'];
    $nama_kuis = $_POST['nama_kuis'];
    $deskripsi_kuis = $_POST['deskripsi_kuis'];

    $sql = "UPDATE kuis 
            SET id_modul = :id_modul, nama_kuis = :nama_kuis, deskripsi_kuis = :deskripsi_kuis 
            WHERE id_kuis = :id_kuis";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_modul' => $id_modul,
        ':nama_kuis' => $nama_kuis,
        ':deskripsi_kuis' => $deskripsi_kuis,
        ':id_kuis' => $id_kuis
    ]);
}

// Proses Hapus Data Kuis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_kuis = $_GET['id'];

    $sql = "DELETE FROM kuis WHERE id_kuis = :id_kuis";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_kuis' => $id_kuis]);
}

// Query untuk mendapatkan data kuis dengan JOIN
$sql = "SELECT kuis.id_kuis, kuis.nama_kuis, kuis.deskripsi_kuis, modul.nama_modul, modul.id_modul 
        FROM kuis
        JOIN modul ON kuis.id_modul = modul.id_modul
        ORDER BY kuis.id_kuis ASC";
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
                <h3>DAFTAR KUIS</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kuis</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Kuis</th>
                            <th>Nama Modul</th>
                            <th>Nama Kuis</th>
                            <th>Deskripsi</th>
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
                                echo "<td>" . htmlspecialchars($row['id_kuis']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_modul']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kuis']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi_kuis']) . "</td>";
                                echo "<td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_kuis'] . "'>Edit</button>
                                <a href='?action=delete&id=" . $row['id_kuis'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                              </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                        <div class='modal fade' id='editModal" . $row['id_kuis'] . "' tabindex='-1'>
                            <div class='modal-dialog'>
                                <form method='POST'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Kuis</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_kuis' value='" . htmlspecialchars($row['id_kuis']) . "'>
                                            <div class='mb-3'>
                                                <label for='id_modul' class='form-label'>Modul</label>
                                                <select class='form-select' name='id_modul' required>
                                                    <option value='" . htmlspecialchars($row['id_modul']) . "' selected>" . htmlspecialchars($row['nama_modul']) . "</option>
                                                </select>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='nama_kuis' class='form-label'>Nama Kuis</label>
                                                <input type='text' class='form-control' name='nama_kuis' value='" . htmlspecialchars($row['nama_kuis']) . "' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='deskripsi_kuis' class='form-label'>Deskripsi</label>
                                                <textarea class='form-control' name='deskripsi_kuis' rows='3' required>" . htmlspecialchars($row['deskripsi_kuis']) . "</textarea>
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

                <!-- Modal Tambah Data Kuis -->
                <div class="modal fade" id="addModal" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Kuis</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="id_modul" class="form-label">Modul</label>
                                        <select class="form-select" name="id_modul" required>
                                            <option value="" disabled selected>Pilih Modul</option>
                                            <?php
                                            $stmt = $pdo->query("SELECT id_modul, nama_modul FROM modul");
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='" . htmlspecialchars($row['id_modul']) . "'>" . htmlspecialchars($row['nama_modul']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_kuis" class="form-label">Nama Kuis</label>
                                        <input type="text" class="form-control" name="nama_kuis" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_kuis" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi_kuis" rows="3" required></textarea>
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