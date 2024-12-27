<?php
include 'config2.php'; // File koneksi database

$sql = "
    SELECT 
        kategori.nama_kategori,
        kelas.nama_kelas,
        modul.nama_modul,
        bab.nama_bab,
        kuis.nama_kuis
    FROM kategori
    JOIN kelas ON kategori.id_kategori = kelas.id_kategori
    LEFT JOIN modul ON kelas.id_kelas = modul.id_kelas
    LEFT JOIN bab ON modul.id_modul = bab.id_modul
    LEFT JOIN kuis ON modul.id_modul = kuis.id_modul
    ORDER BY kategori.nama_kategori, kelas.nama_kelas, modul.nama_modul, bab.nama_bab;
";
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
                <h3>DAFTAR ISI KURSUS</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Kelas</th>
                            <th>Modul</th>
                            <th>Bab</th>
                            <th>Kuis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result) {
                            $no = 1;
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kelas']) . "</td>";
                                echo "<td>" . (!empty($row['nama_modul']) ? htmlspecialchars($row['nama_modul']) : '-') . "</td>";
                                echo "<td>" . (!empty($row['nama_bab']) ? htmlspecialchars($row['nama_bab']) : '-') . "</td>";
                                echo "<td>" . (!empty($row['nama_kuis']) ? htmlspecialchars($row['nama_kuis']) : '-') . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
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