<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data Soal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_kuis = $_POST['id_kuis'];
    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];

    $sql = "INSERT INTO soal_kuis (id_kuis, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
            VALUES (:id_kuis, :pertanyaan, :opsi_a, :opsi_b, :opsi_c, :opsi_d, :jawaban_benar)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_kuis' => $id_kuis,
        ':pertanyaan' => $pertanyaan,
        ':opsi_a' => $opsi_a,
        ':opsi_b' => $opsi_b,
        ':opsi_c' => $opsi_c,
        ':opsi_d' => $opsi_d,
        ':jawaban_benar' => $jawaban_benar
    ]);
}

// Proses Update Data Soal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_soal = $_POST['id_soal'];
    $id_kuis = $_POST['id_kuis'];
    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];

    $sql = "UPDATE soal_kuis 
            SET id_kuis = :id_kuis, pertanyaan = :pertanyaan, opsi_a = :opsi_a, opsi_b = :opsi_b, opsi_c = :opsi_c, opsi_d = :opsi_d, jawaban_benar = :jawaban_benar 
            WHERE id_soal = :id_soal";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_kuis' => $id_kuis,
        ':pertanyaan' => $pertanyaan,
        ':opsi_a' => $opsi_a,
        ':opsi_b' => $opsi_b,
        ':opsi_c' => $opsi_c,
        ':opsi_d' => $opsi_d,
        ':jawaban_benar' => $jawaban_benar,
        ':id_soal' => $id_soal
    ]);
}

// Proses Hapus Data Soal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_soal = $_GET['id'];

    $sql = "DELETE FROM soal_kuis WHERE id_soal = :id_soal";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_soal' => $id_soal]);
}

// Query untuk mendapatkan data soal kuis
$sql = "SELECT soal_kuis.id_soal, soal_kuis.pertanyaan, soal_kuis.opsi_a, soal_kuis.opsi_b, soal_kuis.opsi_c, soal_kuis.opsi_d, soal_kuis.jawaban_benar, kuis.nama_kuis 
        FROM soal_kuis
        JOIN kuis ON soal_kuis.id_kuis = kuis.id_kuis
        ORDER BY soal_kuis.id_soal ASC";
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
                <h3>SOAL KUIS</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Soal Kuis</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Opsi A</th>
                            <th>Opsi B</th>
                            <th>Opsi C</th>
                            <th>Opsi D</th>
                            <th>Jawaban Benar</th>
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
                                echo "<td>" . htmlspecialchars($row['pertanyaan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_a']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_b']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_c']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_d']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['jawaban_benar']) . "</td>";
                                echo "<td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_soal'] . "'>Edit</button>
                            <a href='?action=delete&id=" . $row['id_soal'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                        <div class='modal fade' id='editModal" . $row['id_soal'] . "' tabindex='-1'>
                            <div class='modal-dialog'>
                                <form method='POST'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Soal</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_soal' value='" . htmlspecialchars($row['id_soal']) . "'>
                                            <div class='mb-3'>
                                                <label for='pertanyaan' class='form-label'>Pertanyaan</label>
                                                <textarea class='form-control' name='pertanyaan' required>" . htmlspecialchars($row['pertanyaan']) . "</textarea>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='opsi_a' class='form-label'>Opsi A</label>
                                                <input type='text' class='form-control' name='opsi_a' value='" . htmlspecialchars($row['opsi_a']) . "' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='opsi_b' class='form-label'>Opsi B</label>
                                                <input type='text' class='form-control' name='opsi_b' value='" . htmlspecialchars($row['opsi_b']) . "' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='opsi_c' class='form-label'>Opsi C</label>
                                                <input type='text' class='form-control' name='opsi_c' value='" . htmlspecialchars($row['opsi_c']) . "' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='opsi_d' class='form-label'>Opsi D</label>
                                                <input type='text' class='form-control' name='opsi_d' value='" . htmlspecialchars($row['opsi_d']) . "' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='jawaban_benar' class='form-label'>Jawaban Benar</label>
                                                <input type='text' class='form-control' name='jawaban_benar' value='" . htmlspecialchars($row['jawaban_benar']) . "' required>
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