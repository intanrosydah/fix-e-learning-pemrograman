<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_progres = $_POST['id_progres'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $gambar_sertifikat = $_FILES['gambar_sertifikat']['name'];

    // Proses upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar_sertifikat);
    move_uploaded_file($_FILES['gambar_sertifikat']['tmp_name'], $target_file);

    $sql = "INSERT INTO sertifikat (id_progres, tanggal_terbit, gambar_sertifikat) VALUES (:id_progres, :tanggal_terbit, :gambar_sertifikat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_progres' => $id_progres,
        ':tanggal_terbit' => $tanggal_terbit,
        ':gambar_sertifikat' => $gambar_sertifikat
    ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_sertifikat = $_POST['id_sertifikat'];
    $id_progres = $_POST['id_progres'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $gambar_sertifikat = $_FILES['gambar_sertifikat']['name'];

    // Proses upload gambar jika ada gambar baru
    if ($gambar_sertifikat) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar_sertifikat);
        move_uploaded_file($_FILES['gambar_sertifikat']['tmp_name'], $target_file);

        $sql = "UPDATE sertifikat SET id_progres = :id_progres, tanggal_terbit = :tanggal_terbit, gambar_sertifikat = :gambar_sertifikat WHERE id_sertifikat = :id_sertifikat";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_progres' => $id_progres,
            ':tanggal_terbit' => $tanggal_terbit,
            ':gambar_sertifikat' => $gambar_sertifikat,
            ':id_sertifikat' => $id_sertifikat
        ]);
    } else {
        $sql = "UPDATE sertifikat SET id_progres = :id_progres, tanggal_terbit = :tanggal_terbit WHERE id_sertifikat = :id_sertifikat";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_progres' => $id_progres,
            ':tanggal_terbit' => $tanggal_terbit,
            ':id_sertifikat' => $id_sertifikat
        ]);
    }
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_sertifikat = $_GET['id'];

    $sql = "DELETE FROM sertifikat WHERE id_sertifikat = :id_sertifikat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_sertifikat' => $id_sertifikat]);
}

// Query untuk mendapatkan data
$sql = "SELECT * FROM sertifikat ORDER BY id_sertifikat ASC";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sertifikat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <h3 class="mb-4">Manajemen Sertifikat</h3>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Sertifikat</button>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Progres</th>
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
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_progres']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_terbit']) . "</td>";
                            echo "<td><img src='uploads/" . htmlspecialchars($row['gambar_sertifikat']) . "' alt='Gambar Sertifikat' width='100'></td>";
                            echo "<td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_sertifikat'] . "'>Edit</button>
                                <a href='?action=delete&id=" . $row['id_sertifikat'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>";
                            echo "</tr>";

                            // Modal Edit
                            echo "
                            <div class='modal fade' id='editModal" . $row['id_sertifikat'] . "' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <form method='POST' enctype='multipart/form-data'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Edit Sertifikat</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <input type='hidden' name='id_sertifikat' value='" . htmlspecialchars($row['id_sertifikat']) . "'>
                                                <div class='mb-3'>
                                                    <label for='id_progres' class='form-label'>ID Progres</label>
                                                    <input type='text' class='form-control' name='id_progres' value='" . htmlspecialchars($row['id_progres']) . "' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label for='tanggal_terbit' class='form-label'>Tanggal Terbit</label>
                                                    <input type='date' class='form-control' name='tanggal_terbit' value='" . htmlspecialchars($row['tanggal_terbit']) . "' required>
                                                </div>
                                                <div class='mb-3'>
                                                    <label for='gambar_sertifikat' class='form-label'>Gambar Sertifikat</label>
                                                    <input type='file' class='form-control' name='gambar_sertifikat'>
                                                    <img src='uploads/" . htmlspecialchars($row['gambar_sertifikat']) . "' alt='Gambar Sertifikat' width='100' class='mt-2'>
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

    <!-- Modal Tambah Data -->
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
                            <label for="id_progres" class="form-label">ID Progres</label>
                            <input type="text" class="form-control" name="id_progres" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                            <input type="date" class="form-control" name="tanggal_terbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_sertifikat" class="form-label">Gambar Sertifikat</label>
                            <input type="file" class="form-control" name="gambar_sertifikat" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class='btn btn-secondary' data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class='btn btn-primary'>Simpan</button>
                        <input type="hidden" name="action" value="create">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>