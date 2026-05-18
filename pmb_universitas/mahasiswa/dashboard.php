<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$queryPendaftaran = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id_user='$id_user'");
$dataPendaftaran = mysqli_fetch_assoc($queryPendaftaran);

$status = $dataPendaftaran['status_pendaftaran'] ?? 'Belum Daftar';

$totalDokumen = 0;

if ($dataPendaftaran) {
    $id_pendaftaran = $dataPendaftaran['id_pendaftaran'];

    $queryDokumen = mysqli_query($conn, "SELECT * FROM dokumen WHERE id_pendaftaran='$id_pendaftaran'");

    if (mysqli_num_rows($queryDokumen) > 0) {
        $totalDokumen = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f7fb;
            overflow-x: hidden;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #0d6efd, #001f54);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, .85) !important;
            margin-left: 10px;
            font-weight: 500;
            transition: .3s;
        }

        .nav-link:hover {
            color: white !important;
        }

        .hero-section {
            background: linear-gradient(135deg, #0d6efd, #001f54);
            color: white;
            padding: 70px 0;
            border-radius: 0 0 40px 40px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
        }

        .hero-subtitle {
            opacity: .9;
            margin-top: 15px;
        }

        .dashboard-card {
            background: white;
            border-radius: 25px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
            transition: .3s;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: white;
        }

        .bg-blue {
            background: linear-gradient(135deg, #0d6efd, #4a90ff);
        }

        .bg-green {
            background: linear-gradient(135deg, #198754, #48c78e);
        }

        .bg-orange {
            background: linear-gradient(135deg, #fd7e14, #ffb347);
        }

        .bg-purple {
            background: linear-gradient(135deg, #6f42c1, #9b6dff);
        }

        .dashboard-card h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .dashboard-card h3 {
            font-weight: 700;
        }

        .section-title {
            font-weight: 700;
            color: #001f54;
            margin-bottom: 25px;
        }

        .progress-wrapper {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .step-box {
            text-align: center;
            position: relative;
        }

        .step-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #dee2e6;
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 22px;
            font-weight: 600;
        }

        .step-active {
            background: linear-gradient(135deg, #0d6efd, #001f54);
            color: white;
        }

        .menu-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
            transition: .3s;
            text-decoration: none;
            color: #222;
            display: block;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            color: #0d6efd;
        }

        .menu-icon {
            font-size: 40px;
            margin-bottom: 20px;
        }

        footer {
            background: #001f54;
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-link {
            display: block;
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            margin-bottom: 10px;
        }

        .footer-link:hover {
            color: white;
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, .1);
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            opacity: .8;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">

            <a class="navbar-brand" href="#">
                <i class="bi bi-mortarboard-fill"></i> PMB Kampus
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="biodata.php">Biodata</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="upload.php">Upload Dokumen</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="submit_pendaftaran.php">
                            Submit
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pengumuman.php">Pengumuman</a>
                    </li>

                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-light rounded-pill px-4">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-7">
                    <h1 class="hero-title">
                        Selamat Datang,
                        <?php echo $_SESSION['nama_lengkap']; ?> 👋
                    </h1>

                    <p class="hero-subtitle">
                        Pantau progres pendaftaran, upload dokumen,
                        dan lihat pengumuman hasil seleksi secara online.
                    </p>
                </div>

                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        width="280"
                        class="img-fluid">
                </div>

            </div>
        </div>
    </section>

    <div class="container py-5">

        <div class="row g-4 mb-5">

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">

                    <div class="icon-box bg-blue">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <h5>Status Pendaftaran</h5>
                    <h3 class="text-primary text-capitalize">
                        <?php echo $status; ?>
                    </h3>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">

                    <div class="icon-box bg-green">
                        <i class="bi bi-folder-check"></i>
                    </div>

                    <h5>Dokumen Upload</h5>
                    <h3><?php echo $totalDokumen; ?></h3>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">

                    <div class="icon-box bg-orange">
                        <i class="bi bi-building"></i>
                    </div>

                    <h5>Jurusan Pilihan</h5>
                    <h6 class="fw-bold mt-3">
                        <?php echo $dataPendaftaran['jurusan_pilihan'] ?? '-'; ?>
                    </h6>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">

                    <div class="icon-box bg-purple">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>

                    <h5>Tanggal Daftar</h5>
                    <h6 class="fw-bold mt-3">
                        <?php
                        if (isset($dataPendaftaran['tanggal_daftar'])) {
                            echo date('d M Y', strtotime($dataPendaftaran['tanggal_daftar']));
                        } else {
                            echo '-';
                        }
                        ?>
                    </h6>

                </div>
            </div>

        </div>

        <div class="progress-wrapper mb-5">

            <h3 class="section-title">Progress Pendaftaran</h3>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-circle step-active">
                            <i class="bi bi-person"></i>
                        </div>

                        <h6 class="mt-3 fw-semibold">Registrasi</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-circle <?php echo $dataPendaftaran ? 'step-active' : ''; ?>">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>

                        <h6 class="mt-3 fw-semibold">Isi Biodata</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-circle <?php echo $totalDokumen ? 'step-active' : ''; ?>">
                            <i class="bi bi-cloud-upload"></i>
                        </div>

                        <h6 class="mt-3 fw-semibold">Upload Dokumen</h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-circle <?php echo $status == 'lulus' ? 'step-active' : ''; ?>">
                            <i class="bi bi-trophy"></i>
                        </div>

                        <h6 class="mt-3 fw-semibold">Pengumuman</h6>
                    </div>
                </div>

            </div>

        </div>

        <h3 class="section-title">Menu Utama</h3>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <a href="biodata.php" class="menu-card">

                    <div class="menu-icon text-primary">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <h4 class="fw-bold">Lengkapi Biodata</h4>

                    <p class="text-muted mt-3">
                        Isi data diri dan informasi pendaftaran mahasiswa baru.
                    </p>

                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="upload.php" class="menu-card">

                    <div class="menu-icon text-success">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>

                    <h4 class="fw-bold">Upload Dokumen</h4>

                    <p class="text-muted mt-3">
                        Upload berkas persyaratan pendaftaran secara online.
                    </p>

                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="submit_pendaftaran.php" class="menu-card">

                    <div class="menu-icon text-danger">
                        <i class="bi bi-send-check-fill"></i>
                    </div>

                    <h4 class="fw-bold">Submit Pendaftaran</h4>

                    <p class="text-muted mt-3">
                        Kirim pendaftaran final setelah seluruh data
                        dan dokumen sudah lengkap.
                    </p>

                </a>
            </div>
    
            <div class="col-lg-4 col-md-6">
                <a href="pengumuman.php" class="menu-card">

                    <div class="menu-icon text-warning">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>

                    <h4 class="fw-bold">Pengumuman</h4>

                    <p class="text-muted mt-3">
                        Lihat hasil seleksi dan status kelulusan pendaftaran.
                    </p>

                </a>
            </div>

        </div>

    </div>

    <footer>
        <div class="container">

            <div class="row g-5">

                <div class="col-lg-4">
                    <h4 class="footer-title">PMB Kampus</h4>

                    <p>
                        Sistem Penerimaan Mahasiswa Baru berbasis digital
                        untuk mempermudah proses pendaftaran online.
                    </p>
                </div>

                <div class="col-lg-4">
                    <h4 class="footer-title">Sitemap</h4>

                    <a href="dashboard.php" class="footer-link">Dashboard</a>
                    <a href="biodata.php" class="footer-link">Biodata</a>
                    <a href="upload.php" class="footer-link">Upload Dokumen</a>
                    <a href="pengumuman.php" class="footer-link">Pengumuman</a>
                </div>

                <div class="col-lg-4">
                    <h4 class="footer-title">Lokasi Kampus</h4>

                    <p>
                        <i class="bi bi-geo-alt-fill"></i>
                        Jl. Pendidikan No. 123,
                        Jakarta, Indonesia
                    </p>

                    <p>
                        <i class="bi bi-envelope-fill"></i>
                        info@kampus.ac.id
                    </p>

                    <p>
                        <i class="bi bi-telephone-fill"></i>
                        (021) 12345678
                    </p>
                </div>

            </div>

            <div class="copyright">
                © 2026 PMB Kampus. All Rights Reserved.
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>