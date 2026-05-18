<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'mahasiswa'){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* =========================
   AMBIL DATA PENDAFTARAN
========================= */

$query = mysqli_query($conn, "
SELECT *
FROM pendaftaran
WHERE id_user='$id_user'
");

$data = mysqli_fetch_assoc($query);

$status = $data['status_pendaftaran'] ?? 'draft';

/* =========================
   STATUS SETTING
========================= */

$icon = "bi-hourglass-split";
$title = "Menunggu Hasil Seleksi";
$subtitle = "Pendaftaran kamu sedang diproses oleh panitia PMB.";
$bgClass = "waiting-bg";
$cardClass = "waiting-card";
$badgeClass = "badge-waiting";

if($status == 'lulus'){

    $icon = "bi-trophy-fill";
    $title = "Selamat, Kamu Lulus!";
    $subtitle = "Kamu dinyatakan lolos seleksi PMB dan dapat melanjutkan proses daftar ulang.";
    $bgClass = "success-bg";
    $cardClass = "success-card";
    $badgeClass = "badge-success";

}else if($status == 'tidak_lulus'){

    $icon = "bi-x-circle-fill";
    $title = "Maaf, Kamu Belum Lulus";
    $subtitle = "Tetap semangat dan jangan menyerah untuk mencoba kembali.";
    $bgClass = "danger-bg";
    $cardClass = "danger-card";
    $badgeClass = "badge-danger";

}else if($status == 'seleksi'){

    $icon = "bi-patch-check-fill";
    $title = "Berkas Sudah Diverifikasi";
    $subtitle = "Berkas kamu valid dan sedang menunggu hasil akhir seleksi.";
    $bgClass = "info-bg";
    $cardClass = "info-card";
    $badgeClass = "badge-info";

}else if($status == 'selesai'){

    $icon = "bi bi-check-circle-fill";
    $title = "Pembayaran Berhasil Divalidasi!";
    $subtitle = "Selamat menjadi Mahasiswa baru di Universitas PMB";
    $bgClass = "success-bg";
    $cardClass = "success-card";
    $badgeClass = "badge-success";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengumuman PMB</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: #f4f7fb;
            overflow-x: hidden;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar-custom{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            padding: 16px 0;
        }

        .navbar-brand{
            font-size: 24px;
            font-weight: 700;
            color: white !important;
        }

        .nav-link{
            color: rgba(255,255,255,.85) !important;
            font-weight: 500;
            margin-left: 10px;
            transition: .3s;
        }

        .nav-link:hover,
        .nav-link.active{
            color: white !important;
        }

        /* =========================
           HERO
        ========================= */

        .hero-section{
            padding: 70px 0 120px;
            background: linear-gradient(135deg,#0d6efd,#001f54);
            border-radius: 0 0 45px 45px;
            color: white;
            position: relative;
        }

        .hero-title{
            font-size: 44px;
            font-weight: 700;
        }

        .hero-subtitle{
            margin-top: 18px;
            opacity: .9;
            line-height: 1.8;
        }

        /* =========================
           RESULT CARD
        ========================= */

        .result-wrapper{
            margin-top: -80px;
            position: relative;
            z-index: 5;
        }

        .result-card{
            background: white;
            border-radius: 35px;
            padding: 50px;
            box-shadow: 0 20px 45px rgba(0,0,0,.08);
            text-align: center;
        }

        .result-icon{
            width: 140px;
            height: 140px;
            border-radius: 50%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 65px;
            color: white;
            margin-bottom: 30px;
        }

        .success-bg{
            background: linear-gradient(135deg,#198754,#48c78e);
        }

        .danger-bg{
            background: linear-gradient(135deg,#dc3545,#ff6b81);
        }

        .waiting-bg{
            background: linear-gradient(135deg,#ffc107,#ffb347);
        }

        .info-bg{
            background: linear-gradient(135deg,#0dcaf0,#0d6efd);
        }

        .result-title{
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .result-subtitle{
            color: #666;
            max-width: 700px;
            margin: auto;
            line-height: 1.8;
        }

        /* =========================
           BADGE
        ========================= */

        .status-badge{
            display: inline-block;
            padding: 12px 25px;
            border-radius: 50px;
            margin-top: 25px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-success{
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-danger{
            background: #f8d7da;
            color: #842029;
        }

        .badge-waiting{
            background: #fff3cd;
            color: #856404;
        }

        .badge-info{
            background: #cfe2ff;
            color: #084298;
        }

        /* =========================
           INFO CARD
        ========================= */

        .info-card{
            background: white;
            border-radius: 28px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            margin-top: 35px;
            height: 100%;
        }

        .info-icon{
            width: 75px;
            height: 75px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin-bottom: 25px;
        }

        .blue{
            background: linear-gradient(135deg,#0d6efd,#001f54);
        }

        .green{
            background: linear-gradient(135deg,#198754,#48c78e);
        }

        .orange{
            background: linear-gradient(135deg,#fd7e14,#ffb347);
        }

        .info-card h4{
            font-weight: 700;
            margin-bottom: 18px;
        }

        .info-card p{
            color: #666;
            line-height: 1.8;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-custom{
            padding: 15px 28px;
            border-radius: 16px;
            font-weight: 600;
            border: none;
            margin: 10px;
        }

        .btn-primary-custom{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            color: white;
        }

        .btn-success-custom{
            background: linear-gradient(135deg,#198754,#48c78e);
            color: white;
        }

        .btn-custom:hover{
            transform: translateY(-3px);
            color: white;
        }

        /* =========================
           FOOTER
        ========================= */

        footer{
            background: #001f54;
            color: white;
            padding: 70px 0 20px;
            margin-top: 90px;
        }

        .footer-title{
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-link{
            display: block;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            margin-bottom: 12px;
        }

        .footer-link:hover{
            color: white;
        }

        .copyright{
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            opacity: .8;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width:768px){

            .hero-title{
                font-size: 34px;
            }

            .result-card{
                padding: 35px 25px;
            }

            .result-title{
                font-size: 30px;
            }

        }

    </style>

</head>
<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">

    <div class="container">

        <a class="navbar-brand" href="#">
            <i class="bi bi-mortarboard-fill"></i>
            PMB Kampus
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="biodata.php" class="nav-link">
                        Biodata
                    </a>
                </li>

                <li class="nav-item">
                    <a href="upload.php" class="nav-link">
                        Upload Dokumen
                    </a>
                </li>

                <li class="nav-item">
                        <a class="nav-link" href="submit_pendaftaran.php">
                            Submit
                        </a>
                </li>

                <li class="nav-item">
                    <a href="pengumuman.php" class="nav-link active">
                        Pengumuman
                    </a>
                </li>

                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="logout.php"
                       class="btn btn-light rounded-pill px-4">

                        Logout

                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- HERO -->

<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <h1 class="hero-title">
                    Pengumuman Hasil PMB
                </h1>

                <p class="hero-subtitle">
                    Lihat hasil seleksi penerimaan mahasiswa baru secara online
                    melalui sistem PMB Kampus.
                </p>

            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0">

                <img src="https://cdn-icons-png.flaticon.com/512/4202/4202843.png"
                     class="img-fluid"
                     width="320">

            </div>

        </div>

    </div>

</section>

<!-- RESULT -->

<div class="container result-wrapper">

    <div class="result-card">

        <div class="result-icon <?php echo $bgClass; ?>">

            <i class="bi <?php echo $icon; ?>"></i>

        </div>

        <h1 class="result-title">
            <?php echo $title; ?>
        </h1>

        <p class="result-subtitle">
            <?php echo $subtitle; ?>
        </p>

        <div class="status-badge <?php echo $badgeClass; ?>">

            Status:
            <?php echo ucfirst($status); ?>

        </div>

        <!-- BUTTON -->

        <div class="mt-4">

            <a href="dashboard.php"
               class="btn btn-custom btn-primary-custom">

                <i class="bi bi-house-fill"></i>
                Kembali ke Dashboard

            </a>

            <?php if($status == 'lulus') : ?>

                <a href="daftar_ulang.php"
                   class="btn btn-custom btn-success-custom">

                    <i class="bi bi-check-circle-fill"></i>
                    Daftar Ulang

                </a>

            <?php endif; ?>

        </div>

    </div>

    <!-- INFO -->

    <div class="row mt-4 g-4">

        <div class="col-lg-4">

            <div class="info-card">

                <div class="info-icon blue">

                    <i class="bi bi-person-vcard-fill"></i>

                </div>

                <h4>Nomor Pendaftaran</h4>

                <p>
                    <?php echo $data['nomor_pendaftaran'] ?? '-'; ?>
                </p>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="info-card">

                <div class="info-icon green">

                    <i class="bi bi-building-fill"></i>

                </div>

                <h4>Jurusan Pilihan</h4>

                <p>
                    <?php echo $data['jurusan_pilihan'] ?? '-'; ?>
                </p>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="info-card">

                <div class="info-icon orange">

                    <i class="bi bi-calendar-check-fill"></i>

                </div>

                <h4>Tanggal Pendaftaran</h4>

                <p>

                    <?php

                    if(isset($data['tanggal_daftar'])){
                        echo date('d F Y', strtotime($data['tanggal_daftar']));
                    }else{
                        echo '-';
                    }

                    ?>

                </p>

            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->

<footer>

    <div class="container">

        <div class="row g-5">

            <div class="col-lg-4">

                <h4 class="footer-title">
                    PMB Kampus
                </h4>

                <p>
                    Sistem Penerimaan Mahasiswa Baru berbasis digital
                    untuk mempermudah proses pendaftaran online.
                </p>

            </div>

            <div class="col-lg-4">

                <h4 class="footer-title">
                    Sitemap
                </h4>

                <a href="dashboard.php" class="footer-link">
                    Dashboard
                </a>

                <a href="biodata.php" class="footer-link">
                    Biodata
                </a>

                <a href="upload.php" class="footer-link">
                    Upload Dokumen
                </a>

                <a href="pengumuman.php" class="footer-link">
                    Pengumuman
                </a>

            </div>

            <div class="col-lg-4">

                <h4 class="footer-title">
                    Lokasi Kampus
                </h4>

                <p>
                    <i class="bi bi-geo-alt-fill"></i>
                    Jl. Pendidikan No.123, Jakarta
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