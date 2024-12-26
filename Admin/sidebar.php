<!-- Sidebar -->
<div class="sidebar">
    <div class="text-center mb-3">
        <img
            src="https://via.placeholder.com/50"
            class="rounded-circle"
            alt="User" />
        <p>Admin</p>
    </div>
    <a href="#" class="d-block mb-2">Home</a>

    <!-- Dropdown Manajemen Pengguna -->
    <a
        class="dropdown-toggle d-block mb-2"
        data-bs-toggle="collapse"
        href="#manajemenPengguna"
        role="button"
        aria-expanded="false"
        aria-controls="manajemenPengguna">
        Manajemen Pengguna
    </a>
    <div class="collapse ms-3" id="manajemenPengguna">
        <a href="data-pengguna.php" class="d-block ">Data Pengguna</a>
        <a href="monitoring-aktivitas.php" class="d-block">Monitoring Aktivitas Pengguna</a>
        <a href="manajemen-sertifikat.php" class="d-block">Sertifikat Pengguna</a>
    </div>

    <!-- Dropdown Manajemen Kursus -->
    <a
        class="dropdown-toggle d-block mb-2"
        data-bs-toggle="collapse"
        href="#manajemenKursus"
        role="button"
        aria-expanded="false"
        aria-controls="manajemenKursus">
        Manajemen Kursus
    </a>
    <div class="collapse ms-3" id="manajemenKursus">
        <a href="manajemen-jadwal-kursus.php" class="d-block">Jadwal Kursus</a>
        <a href="manajemen-paket-kursus.php" class="d-block">Paket Kursus</a>
        <a href="manajemen-kategori-kursus.php" class="d-block">Kategori Kursus</a>
        <a href="manajemen-kelas-kursus.php" class="d-block">Kelas Kursus</a>
        <a href="manajemen-modul-kursus.php" class="d-block">Modul Kursus</a>
        <a href="manajemen-bab-kursus.php" class="d-block">Bab Kursus</a>
        <a href="manajemen-kuis-kursus.php" class="d-block">Kuis Kursus</a>
        <a href="manajemen-soal-kuis-kursus.php" class="d-block">Soal Kuis Kursus</a>
    </div>

    <!-- Dropdown Manajemen Pembayaran -->
    <a
        class="dropdown-toggle d-block mb-2"
        data-bs-toggle="collapse"
        href="#manajemenPembayaran"
        role="button"
        aria-expanded="false"
        aria-controls="manajemenPembayaran">
        Manajemen Pembayaran
    </a>
    <div class="collapse ms-3" id="manajemenPembayaran">
        <a href="manajemen-pembayaran.php" class="d-block">Riwayat Pembayaran</a>
        <a href="manajemen-metode-pembayaran.php" class="d-block">Metode Pembayaran</a>
        <a href="manajemen-nomor-va.php" class="d-block">Nomor VA</a>
    </div>

    <!-- Dropdown Manajemen Kelola Daily Coding -->
    <a
        class="dropdown-toggle d-block mb-2"
        data-bs-toggle="collapse"
        href="#manajemenDailyCoding"
        role="button"
        aria-expanded="false"
        aria-controls="manajemenDailyCoding">
        Manajemen Daily Coding
    </a>
    <div class="collapse ms-3" id="manajemenDailyCoding">
        <a href="manajemen-daily_coding.php" class="d-block">Daily Coding</a>
        <a href="manajemen-progres_api.php" class="d-block">Riwayat Progres Api</a>
        <a href="manajemen-tukar_api.php" class="d-block">Riwayat Tukar Api</a>
    </div>

    <a href="index.php" class="d-block mt-2">Logout</a>
</div>

<!-- Header/Navbar -->
<nav
    class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
    style="margin-left: 250px">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="fix-e-learning-pemrograman/images/new-logo.png" alt="Logo" />
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