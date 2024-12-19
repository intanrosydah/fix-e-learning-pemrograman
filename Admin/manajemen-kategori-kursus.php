<?php
include 'config2.php'; // Koneksi database

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi_kategori = $_POST['deskripsi_kategori'];

    $sql = "INSERT INTO kategori (nama_kategori, deskripsi_kategori) VALUES (:nama_kategori, :deskripsi_kategori)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nama_kategori' => $nama_kategori, ':deskripsi_kategori' => $deskripsi_kategori]);
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi_kategori = $_POST['deskripsi_kategori'];

    $sql = "UPDATE kategori SET nama_kategori = :nama_kategori, deskripsi_kategori = :deskripsi_kategori WHERE id_kategori = :id_kategori";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nama_kategori' => $nama_kategori, ':deskripsi_kategori' => $deskripsi_kategori, ':id_kategori' => $id_kategori]);
}

// Proses Hapus Data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_kategori = $_GET['id'];

    $sql = "DELETE FROM kategori WHERE id_kategori = :id_kategori";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_kategori' => $id_kategori]);
}

// Query untuk mendapatkan data kategori
$sql = "SELECT * FROM kategori";
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
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-3">
            <img
                src="https://via.placeholder.com/50"
                class="rounded-circle"
                alt="User" />
            <p>Admin</p>
        </div>
        <a href="#">Home</a>

        <!-- Dropdown Manajemen Pengguna -->
        <a
            class="dropdown-toggle"
            data-bs-toggle="collapse"
            href="#manajemenPengguna"
            role="button"
            aria-expanded="false"
            aria-controls="manajemenPengguna">
            Manajemen Pengguna
        </a>
        <div class="collapse" id="manajemenPengguna">
            <a href="data-pengguna.php">Data Pengguna</a>
            <a href="monitoring-aktivitas.php">Monitoring Aktivitas Pengguna</a>
            <a href="manajemen-sertifikat.php">Sertifikat Pengguna</a>
        </div>

        <!-- Dropdown Manajemen Kursus -->
        <a
            class="dropdown-toggle"
            data-bs-toggle="collapse"
            href="#manajemenKursus"
            role="button"
            aria-expanded="false"
            aria-controls="manajemenKursus">
            Manajemen Kursus
        </a>
        <div class="collapse" id="manajemenKursus">
            <a href="manajemen-jadwal-kursus.php">Jadwal Kursus</a>
            <a href="manajemen-kategori-kursus.php">Kategori Kursus</a>
            <a href="manajemen-kelas-kursus.php">Kelas Kursus</a>
            <a href="manajemen-modul-kursus.php">Modul Kursus</a>
        </div>

        <!-- Dropdown Manajemen Pembayaran -->
        <a
            class="dropdown-toggle"
            data-bs-toggle="collapse"
            href="#manajemenPembayaran"
            role="button"
            aria-expanded="false"
            aria-controls="manajemenPembayaran">
            Manajemen Pembayaran
        </a>
        <div class="collapse" id="manajemenPembayaran">
            <a href="manajemen-pembayaran.php">Riwayat Pembayaran</a>
        </div>

        <a href="index.php">Logout</a>
    </div>

    <!-- Header/Navbar -->
    <nav
        class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
        style="margin-left: 250px">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/new-logo.png" alt="Logo" />
                AIFYCODE Learning
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <form class="d-flex">
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="content pt-5 mt-3">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>KATEGORI KURSUS</h3>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kategori</button>
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
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi Kategori</th>
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
                                echo "<td>" . htmlspecialchars($row['id_kategori']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi_kategori']) . "</td>";
                                echo "<td>
                                    <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id_kategori'] . "'>Edit</button>
                                    <a href='?action=delete&id=" . $row['id_kategori'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                </td>";
                                echo "</tr>";

                                // Modal Edit
                                echo "
                                <div class='modal fade' id='editModal" . $row['id_kategori'] . "' tabindex='-1'>
                                    <div class='modal-dialog'>
                                        <form method='POST'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title'>Edit Kategori</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <input type='hidden' name='id_kategori' value='" . htmlspecialchars($row['id_kategori']) . "'>
                                                    <div class='mb-3'>
                                                        <label for='nama_kategori' class='form-label'>Nama Kategori</label>
                                                        <input type='text' class='form-control' name='nama_kategori' value='" . htmlspecialchars($row['nama_kategori']) . "' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label for='deskripsi_kategori' class='form-label'>Deskripsi</label>
                                                        <textarea class='form-control' name='deskripsi_kategori' rows='3' required>" . htmlspecialchars($row['deskripsi_kategori']) . "</textarea>
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
                                <h5 class="modal-title">Tambah Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_kategori" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi_kategori" rows="3" required></textarea>
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