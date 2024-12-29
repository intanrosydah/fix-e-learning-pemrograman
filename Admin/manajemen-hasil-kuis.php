<?php
include 'config2.php'; // File koneksi database

// Ambil data user untuk dropdown
$sqlUsers = "SELECT id, name FROM user";
$users = $pdo->query($sqlUsers)->fetchAll(PDO::FETCH_ASSOC);

// Ambil data kuis untuk dropdown
$sqlKuis = "SELECT id_kuis, nama_kuis FROM kuis";
$kuis = $pdo->query($sqlKuis)->fetchAll(PDO::FETCH_ASSOC);

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_user = $_POST['id_user'];
    $id_kuis = $_POST['id_kuis'];
    $skor = $_POST['skor'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $sql = "INSERT INTO hasil_kuis (id_user, id_kuis, skor, tanggal_selesai) 
            VALUES (:id_user, :id_kuis, :skor, :tanggal_selesai)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_user' => $id_user,
        ':id_kuis' => $id_kuis,
        ':skor' => $skor,
        ':tanggal_selesai' => $tanggal_selesai
    ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_hasil = $_POST['id_hasil'];
    $id_user = $_POST['id_user'];
    $id_kuis = $_POST['id_kuis'];
    $skor = $_POST['skor'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $sql = "UPDATE hasil_kuis 
            SET id_user = :id_user, id_kuis = :id_kuis, skor = :skor, tanggal_selesai = :tanggal_selesai 
            WHERE id_hasil = :id_hasil";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_hasil' => $id_hasil,
        ':id_user' => $id_user,
        ':id_kuis' => $id_kuis,
        ':skor' => $skor,
        ':tanggal_selesai' => $tanggal_selesai
    ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_hasil = $_GET['id'];

    $sql = "DELETE FROM hasil_kuis WHERE id_hasil = :id_hasil";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_hasil' => $id_hasil]);
}



// Query untuk mendapatkan data dengan JOIN
$sql = "SELECT hasil_kuis.id_hasil, hasil_kuis.id_user, hasil_kuis.id_kuis, hasil_kuis.skor, hasil_kuis.tanggal_selesai, 
        user.name AS nama_user, kuis.nama_kuis
        FROM hasil_kuis
        JOIN user ON hasil_kuis.id_user = user.id
        JOIN kuis ON hasil_kuis.id_kuis = kuis.id_kuis
        ORDER BY hasil_kuis.id_hasil ASC";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HASIL KUIS</title>
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
        <di class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>HASIL KUIS PENGGUNA</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Hasil Kuis</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Nama Kuis</th>
                            <th>Skor</th>
                            <th>Tanggal Selesai</th>
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
                                echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kuis']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['skor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tanggal_selesai']) . "</td>";
                                echo "<td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_hasil'] . "'>Edit</button>
                            <a href='?action=delete&id=" . $row['id_hasil'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
<div class='modal fade' id='editModal" . $row['id_hasil'] . "' tabindex='-1'>
    <div class='modal-dialog'>
        <form method='POST'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Edit Hasil Kuis</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                </div>
                <div class='modal-body'>
                    <input type='hidden' name='id_hasil' value='" . htmlspecialchars($row['id_hasil']) . "'>

                    <div class='mb-3'>
                        <label for='id_user' class='form-label'>Nama Pengguna</label>
                        <select class='form-select' name='id_user' required>
                            <option value=''>Pilih Pengguna</option>";
                                foreach ($users as $user) {
                                    $selected = $row['id_user'] == $user['id'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($user['id']) . "' $selected>" . htmlspecialchars($user['name']) . "</option>";
                                }
                                echo "
                        </select>
                    </div>

                    <div class='mb-3'>
                        <label for='id_kuis' class='form-label'>Nama Kuis</label>
                        <select class='form-select' name='id_kuis' required>
                            <option value=''>Pilih Kuis</option>";
                                foreach ($kuis as $k) {
                                    $selected = $row['id_kuis'] == $k['id_kuis'] ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($k['id_kuis']) . "' $selected>" . htmlspecialchars($k['nama_kuis']) . "</option>";
                                }
                                echo "
                        </select>
                    </div>

                    <div class='mb-3'>
                        <label for='skor' class='form-label'>Skor</label>
                        <input type='number' class='form-control' name='skor' value='" . htmlspecialchars($row['skor']) . "' required>
                    </div>

                    <div class='mb-3'>
                        <label for='tanggal_selesai' class='form-label'>Tanggal Selesai</label>
                        <input type='date' class='form-control' name='tanggal_selesai' value='" . htmlspecialchars($row['tanggal_selesai']) . "' required>
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

            <!-- Modal Tambah -->
            <div class="modal fade" id="addModal" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Hasil Kuis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_user" class="form-label">Nama User</label>
                                    <select class="form-select" name="id_user" required>
                                        <option value="">Pilih User</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_kuis" class="form-label">Nama Kuis</label>
                                    <select class="form-select" name="id_kuis" required>
                                        <option value="">Pilih Kuis</option>
                                        <?php foreach ($kuis as $k): ?>
                                            <option value="<?= htmlspecialchars($k['id_kuis']) ?>"><?= htmlspecialchars($k['nama_kuis']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="skor" class="form-label">Skor</label>
                                    <input type="number" class="form-control" name="skor" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai">
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