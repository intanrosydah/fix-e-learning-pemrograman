<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_nomor_va = $_POST['id_nomor_va'];
    $nama_metode_pembayaran = $_POST['nama_metode_pembayaran'];

    $sql = "INSERT INTO metode_pembayaran (id_nomor_va, nama_metode_pembayaran) 
            VALUES (:id_nomor_va, :nama_metode_pembayaran)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_nomor_va' => $id_nomor_va,
        ':nama_metode_pembayaran' => $nama_metode_pembayaran
    ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
    $id_nomor_va = $_POST['id_nomor_va'];
    $nama_metode_pembayaran = $_POST['nama_metode_pembayaran'];

    $sql = "UPDATE metode_pembayaran 
            SET id_nomor_va = :id_nomor_va, nama_metode_pembayaran = :nama_metode_pembayaran 
            WHERE id_metode_pembayaran = :id_metode_pembayaran";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_metode_pembayaran' => $id_metode_pembayaran,
        ':id_nomor_va' => $id_nomor_va,
        ':nama_metode_pembayaran' => $nama_metode_pembayaran
    ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_metode_pembayaran = $_GET['id'];

    $sql = "DELETE FROM metode_pembayaran WHERE id_metode_pembayaran = :id_metode_pembayaran";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_metode_pembayaran' => $id_metode_pembayaran]);
}

// Query untuk mendapatkan data metode pembayaran
$sql = "SELECT metode_pembayaran.id_metode_pembayaran, nomor_va.nomor_va, metode_pembayaran.nama_metode_pembayaran  
        FROM metode_pembayaran 
        JOIN nomor_va ON metode_pembayaran.id_nomor_va = nomor_va.id_nomor_va
        ORDER BY id_metode_pembayaran ASC";
$result = $pdo->query($sql);

// Query untuk mendapatkan data nomor VA untuk dropdown
$sql_va = "SELECT id_nomor_va, nomor_va FROM nomor_va ORDER BY nomor_va ASC";
$va_result = $pdo->query($sql_va);
$va_options = $va_result->fetchAll(PDO::FETCH_ASSOC);
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
                <h3>METODE PEMBAYARAN</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Metode Pembayaran</button>
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
                            <th>ID Metode Pembayaran</th>
                            <th>Nomor VA</th>
                            <th>Nama Metode</th>
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
                                echo "<td>" . htmlspecialchars($row['id_metode_pembayaran']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nomor_va']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_metode_pembayaran']) . "</td>";
                                echo "<td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_metode_pembayaran'] . "'>Edit</button>
                                <a href='?action=delete&id=" . $row['id_metode_pembayaran'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                              </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                        <div class='modal fade' id='editModal" . $row['id_metode_pembayaran'] . "' tabindex='-1'>
                            <div class='modal-dialog'>
                                <form method='POST'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Metode Pembayaran</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_metode_pembayaran' value='" . htmlspecialchars($row['id_metode_pembayaran']) . "'>
                                            <div class='mb-3'>
                                                <label class='form-label'>Nomor VA</label>
                                                <select class='form-select' name='id_nomor_va' required>";

                                foreach ($va_options as $option) {
                                    $selected = $option['id_nomor_va'] == $row['id_nomor_va'] ? 'selected' : '';
                                    echo "<option value='" . $option['id_nomor_va'] . "' $selected>" . htmlspecialchars($option['nomor_va']) . "</option>";
                                }

                                echo "</select>
                                            </div>
                                            <div class='mb-3'>
                                                <label class='form-label'>Nama Metode</label>
                                                <input type='text' class='form-control' name='nama_metode_pembayaran' value='" . htmlspecialchars($row['nama_metode_pembayaran']) . "' required>
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
                                <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nomor VA</label>
                                    <select class="form-select" name="id_nomor_va" required>
                                        <option value="" disabled selected>Pilih Nomor VA</option>
                                        <?php
                                        foreach ($va_options as $option) {
                                            echo "<option value='" . $option['id_nomor_va'] . "'>" . htmlspecialchars($option['nomor_va']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Metode</label>
                                    <input type="text" class="form-control" name="nama_metode_pembayaran" required>
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