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
        <a href="manajemen-paket-kursus.php">Paket Kursus</a>
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

        <!-- Dropdown Manajemen Kelola Daily Coding -->
        <a
        class="dropdown-toggle"
        data-bs-toggle="collapse"
        href="#manajemenDailyCoding"
        role="button"
        aria-expanded="false"
        aria-controls="manajemenDailyCoding">
        Manajemen Daily Coding
    </a>
    <div class="collapse" id="manajemenDailyCoding">
        <a href="manajemen-daily_coding.php">Daily Coding</a>
        <a href="manajemen-user_daily_coding.php">Riwayat Daily Coding</a>
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