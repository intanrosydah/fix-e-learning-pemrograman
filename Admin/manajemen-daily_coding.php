<?php
include 'config2.php'; // File koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $kode_soal = $_POST['kode_soal'];
    $deskripsi_tantangan = $_POST['deskripsi_tantangan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];
    $reward_api = $_POST['reward_api'];

    $sql = "INSERT INTO daily_coding (kode_soal, deskripsi_tantangan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar, reward_api) 
            VALUES (:kode_soal, :deskripsi_tantangan, :opsi_a, :opsi_b, :opsi_c, :opsi_d, :jawaban_benar, :reward_api)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':kode_soal' => $kode_soal,
        ':deskripsi_tantangan' => $deskripsi_tantangan,
        ':opsi_a' => $opsi_a,
        ':opsi_b' => $opsi_b,
        ':opsi_c' => $opsi_c,
        ':opsi_d' => $opsi_d,
        ':jawaban_benar' => $jawaban_benar,
        ':reward_api' => $reward_api
    ]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_daily_coding = $_POST['id_daily_coding'];
    $kode_soal = $_POST['kode_soal'];
    $deskripsi_tantangan = $_POST['deskripsi_tantangan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];
    $reward_api = $_POST['reward_api'];

    $sql = "UPDATE daily_coding 
            SET kode_soal = :kode_soal, deskripsi_tantangan = :deskripsi_tantangan, opsi_a = :opsi_a, opsi_b = :opsi_b, opsi_c = :opsi_c, opsi_d = :opsi_d, jawaban_benar = :jawaban_benar, reward_api = :reward_api 
            WHERE id_daily_coding = :id_daily_coding";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':kode_soal' => $kode_soal,
        ':deskripsi_tantangan' => $deskripsi_tantangan,
        ':opsi_a' => $opsi_a,
        ':opsi_b' => $opsi_b,
        ':opsi_c' => $opsi_c,
        ':opsi_d' => $opsi_d,
        ':jawaban_benar' => $jawaban_benar,
        ':reward_api' => $reward_api,
        ':id_daily_coding' => $id_daily_coding
    ]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_daily_coding = $_GET['id'];

    $sql = "DELETE FROM daily_coding WHERE id_daily_coding = :id_daily_coding";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_daily_coding' => $id_daily_coding]);
}

// Query untuk mendapatkan data
$sql = "SELECT * FROM daily_coding ORDER BY id_daily_coding ASC";
$result = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SISFO - Daily Coding</title>
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
                <h3>DAILY CODING</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Daily Coding</button>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Daily Coding</th>
                            <th>Kode Soal</th>
                            <th>Deskripsi</th>
                            <th>Opsi A</th>
                            <th>Opsi B</th>
                            <th>Opsi C</th>
                            <th>Opsi D</th>
                            <th>Jawaban Benar</th>
                            <th>Reward Api</th>
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
                                echo "<td>" . htmlspecialchars($row['id_daily_coding']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['kode_soal']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi_tantangan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_a']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_b']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_c']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['opsi_d']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['jawaban_benar']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['reward_api']) . "</td>";
                                echo "<td>
                           <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_daily_coding'] . "'>Edit</button>
                           <a href='?action=delete&id=" . $row['id_daily_coding'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                <div class='modal fade' id='editModal" . $row['id_daily_coding'] . "' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form method='POST'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Data</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_daily_coding' value='" . htmlspecialchars($row['id_daily_coding']) . "'>
                                    <div class='mb-3'>
                                        <label for='kode_soal' class='form-label'>Kode Soal</label>
                                        <input type='text' class='form-control' name='kode_soal' value='" . htmlspecialchars($row['kode_soal']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='deskripsi_tantangan' class='form-label'>Deskripsi</label>
                                        <textarea class='form-control' name='deskripsi_tantangan' rows='3' required>" . htmlspecialchars($row['deskripsi_tantangan']) . "</textarea>
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
                                        <label for='jawaban_benar' class='form-label'>Jawaban</label>
                                        <input type='text' class='form-control' name='jawaban_benar' value='" . htmlspecialchars($row['jawaban_benar']) . "' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='reward_api' class='form-label'>Reward</label>
                                        <input type='number' class='form-control' name='reward_api' value='" . htmlspecialchars($row['reward_api']) . "' required>
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
                                <h5 class="modal-title">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_daily_coding" class="form-label">ID Daily Coding</label>
                                    <input type="text" class="form-control" name="id_daily_coding" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_soal" class="form-label">Kode Soal</label>
                                    <input type="text" class="form-control" name="kode_soal" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_tantangan" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi_tantangan" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="opsi_a" class="form-label">Opsi A</label>
                                    <input type="text" class="form-control" name="opsi_a" required>
                                </div>
                                <div class="mb-3">
                                    <label for="opsi_b" class="form-label">Opsi B</label>
                                    <input type="text" class="form-control" name="opsi_b" required>
                                </div>
                                <div class="mb-3">
                                    <label for="opsi_c" class="form-label">Opsi C</label>
                                    <input type="text" class="form-control" name="opsi_c" required>
                                </div>
                                <div class="mb-3">
                                    <label for="opsi_d" class="form-label">Opsi D</label>
                                    <input type="text" class="form-control" name="opsi_d" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                                    <input type="text" class="form-control" name="jawaban_benar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reward_api" class="form-label">Reward Api</label>
                                    <input type="number" class="form-control" name="reward_api" required>
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
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>