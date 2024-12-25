<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nomor_va = $_POST['nomor_va'];

    $sql = "INSERT INTO nomor_va (nomor_va) VALUES (:nomor_va)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nomor_va' => $nomor_va]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_nomor_va = $_POST['id_nomor_va'];
    $nomor_va = $_POST['nomor_va'];

    $sql = "UPDATE nomor_va SET nomor_va = :nomor_va WHERE id_nomor_va = :id_nomor_va";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_nomor_va' => $id_nomor_va,
        ':nomor_va' => $nomor_va
    ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_nomor_va = $_GET['id'];

    $sql = "DELETE FROM nomor_va WHERE id_nomor_va = :id_nomor_va";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_nomor_va' => $id_nomor_va]);
}

// Query untuk mendapatkan data nomor VA
$sql = "SELECT id_nomor_va, nomor_va FROM nomor_va ORDER BY id_nomor_va ASC";
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
                <h3>NOMOR VA</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Nomor VA</button>
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
                            <th>ID Nomor VA</th>
                            <th>Nomor VA</th>
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
                                echo "<td>" . htmlspecialchars($row['id_nomor_va']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nomor_va']) . "</td>";
                                echo "<td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_nomor_va'] . "'>Edit</button>
                            <a href='?action=delete&id=" . $row['id_nomor_va'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                        <div class='modal fade' id='editModal" . $row['id_nomor_va'] . "' tabindex='-1'>
                            <div class='modal-dialog'>
                                <form method='POST'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Nomor VA</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_nomor_va' value='" . htmlspecialchars($row['id_nomor_va']) . "'>
                                            <div class='mb-3'>
                                                <label class='form-label'>Nomor VA</label>
                                                <input type='text' class='form-control' name='nomor_va' value='" . htmlspecialchars($row['nomor_va']) . "' required>
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
                                <h5 class="modal-title">Tambah Nomor VA</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nomor VA</label>
                                    <input type="text" class="form-control" name="nomor_va" required>
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