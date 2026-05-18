<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'mahasiswa'){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$queryPendaftaran = mysqli_query($conn, "SELECT * FROM pendaftaran 
WHERE id_user='$id_user'");

$pendaftaran = mysqli_fetch_assoc($queryPendaftaran);

if(!$pendaftaran){
    header("Location: biodata.php");
    exit;
}

$id_pendaftaran = $pendaftaran['id_pendaftaran'];

$queryDokumen = mysqli_query($conn, "SELECT * FROM dokumen 
WHERE id_pendaftaran='$id_pendaftaran'");

$dokumen = mysqli_fetch_assoc($queryDokumen);

$status = $pendaftaran['status_pendaftaran'];

function cekDokumen($data){
    return !empty($data);
}

$totalLengkap = 0;

if(cekDokumen($dokumen['foto'] ?? '')) $totalLengkap++;
if(cekDokumen($dokumen['ktp'] ?? '')) $totalLengkap++;
if(cekDokumen($dokumen['kartu_keluarga'] ?? '')) $totalLengkap++;
if(cekDokumen($dokumen['ijazah'] ?? '')) $totalLengkap++;
if(cekDokumen($dokumen['raport'] ?? '')) $totalLengkap++;
if(cekDokumen($dokumen['sertifikat'] ?? '')) $totalLengkap++;

$siapSubmit = $totalLengkap >= 5;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Pendaftaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: #f4f7fb;
            overflow-x: hidden;
        }

        .navbar-custom{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            padding: 15px 0;
        }

        .navbar-brand{
            font-weight: 700;
            font-size: 24px;
            color: white !important;
        }

        .nav-link{
            color: rgba(255,255,255,.85) !important;
            margin-left: 10px;
            font-weight: 500;
        }

        .nav-link:hover{
            color: white !important;
        }

        .hero-section{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            color: white;
            padding: 60px 0;
            border-radius: 0 0 40px 40px;
        }

        .hero-title{
            font-size: 42px;
            font-weight: 700;
        }

        .hero-subtitle{
            margin-top: 15px;
            opacity: .9;
        }

        .submit-wrapper{
            margin-top: -40px;
        }

        .submit-card{
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,.08);
        }

        .section-title{
            font-weight: 700;
            color: #001f54;
            margin-bottom: 25px;
        }

        .info-box{
            background: #f7faff;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .info-box h5{
            font-weight: 600;
            margin-bottom: 20px;
        }

        .status-badge{
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .status-draft{
            background: #fff3cd;
            color: #856404;
        }

        .status-submit{
            background: #d1e7dd;
            color: #0f5132;
        }

        .check-item{
            background: #f8fbff;
            border-radius: 15px;
            padding: 18px 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .check-item i{
            font-size: 22px;
        }

        .btn-submit{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
            border-radius: 15px;
            height: 58px;
            padding: 0 40px;
            font-weight: 600;
            font-size: 17px;
        }

        .btn-submit:hover{
            opacity: .95;
        }

        .summary-card{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            color: white;
            border-radius: 25px;
            padding: 35px;
            height: 100%;
        }

        .summary-icon{
            font-size: 60px;
            margin-bottom: 20px;
        }

        .progress{
            height: 14px;
            border-radius: 50px;
            margin-top: 15px;
        }

        footer{
            background: #001f54;
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
        }

        .footer-title{
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-link{
            display: block;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            margin-bottom: 10px;
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

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">

    <div class="container">

        <a class="navbar-brand" href="dashboard.php">
            <i class="bi bi-mortarboard-fill"></i> PMB Kampus
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="biodata.php">Biodata</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Upload Dokumen</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="submit_pendaftaran.php">
                        Submit
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pengumuman.php">Pengumuman</a>
                </li>

                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="../logout.php" class="btn btn-light rounded-pill px-4">
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
                    Submit Final Pendaftaran
                </h1>

                <p class="hero-subtitle">
                    Pastikan seluruh biodata dan dokumen sudah lengkap
                    sebelum mengirim pendaftaran ke tahap verifikasi admin.
                </p>

            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0">

                <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png"
                     width="280"
                     class="img-fluid">

            </div>

        </div>

    </div>

</section>

<div class="container submit-wrapper pb-5">

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="submit-card">

                <h3 class="section-title">
                    Konfirmasi Pendaftaran
                </h3>

                <?php if(isset($_GET['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Pendaftaran berhasil dikirim.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="info-box">

                    <h5>
                        Informasi Pendaftaran
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Nomor Pendaftaran</strong>
                            <br>
                            <?= $pendaftaran['nomor_pendaftaran']; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Nama Lengkap</strong>
                            <br>
                            <?= $_SESSION['nama_lengkap']; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Jurusan Pilihan</strong>
                            <br>
                            <?= $pendaftaran['jurusan_pilihan']; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Status</strong>
                            <br>

                            <?php if($status == 'submitted') : ?>

                                <span class="status-badge status-submit">
                                    Submitted
                                </span>

                            <?php elseif($status == 'selesai') : ?>

                                <span class="status-badge status-submit">
                                    Selesai
                                </span>

                            <?php else : ?>

                                <span class="status-badge status-draft">
                                    Draft
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <h5 class="fw-bold mb-4">
                    Checklist Dokumen
                </h5>

                <div class="check-item">

                    <span>Pas Foto</span>

                    <?php if(!empty($dokumen['foto'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="check-item">

                    <span>KTP</span>

                    <?php if(!empty($dokumen['ktp'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="check-item">

                    <span>Kartu Keluarga</span>

                    <?php if(!empty($dokumen['kartu_keluarga'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="check-item">

                    <span>Ijazah</span>

                    <?php if(!empty($dokumen['ijazah'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="check-item">

                    <span>Raport</span>

                    <?php if(!empty($dokumen['raport'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="check-item">

                    <span>Sertifikat</span>

                    <?php if(!empty($dokumen['sertifikat'])) : ?>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    <?php else : ?>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    <?php endif; ?>

                </div>

                <div class="mt-5">

                    <?php if($status == 'submitted') : ?>

                        <button class="btn btn-success btn-submit w-100" disabled>
                            <i class="bi bi-check-circle-fill"></i>
                            Pendaftaran Sudah Dikirim
                        </button>

                    <?php elseif($siapSubmit) : ?>

                        <form action="proses_submit.php" method="POST">

                            <button type="submit"
                                    class="btn btn-primary btn-submit w-100">

                                <i class="bi bi-send-fill"></i>
                                Submit Pendaftaran Final

                            </button>

                        </form>

                    <?php else : ?>

                        <button class="btn btn-secondary btn-submit w-100" disabled>

                            <i class="bi bi-exclamation-circle-fill"></i>
                            Lengkapi Dokumen Terlebih Dahulu

                        </button>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="bi bi-clipboard-check-fill"></i>
                </div>

                <h3 class="fw-bold">
                    Status Kelengkapan
                </h3>

                <p class="mt-3">
                    Pastikan seluruh data dan dokumen
                    sudah lengkap sebelum submit final.
                </p>

                <div class="mt-4">

                    <h1 class="fw-bold">
                        <?= $totalLengkap; ?>/6
                    </h1>

                    <p>Dokumen Lengkap</p>

                    <div class="progress">

                        <div class="progress-bar"
                             role="progressbar"
                             style="width: <?= ($totalLengkap/6)*100; ?>%">

                        </div>

                    </div>

                </div>

                <hr class="my-4">

                <p class="mb-0">
                    Setelah submit,
                    data tidak dapat diubah
                    selama proses verifikasi berlangsung.
                </p>

            </div>

        </div>

    </div>

</div>

<footer>

    <div class="container">

        <div class="row g-5">

            <div class="col-lg-4">

                <h4 class="footer-title">
                    PMB Kampus
                </h4>

                <p>
                    Sistem Penerimaan Mahasiswa Baru
                    berbasis digital modern dan terintegrasi.
                </p>

            </div>

            <div class="col-lg-4">

                <h4 class="footer-title">
                    Sitemap
                </h4>

                <a href="dashboard.php" class="footer-link">Dashboard</a>
                <a href="biodata.php" class="footer-link">Biodata</a>
                <a href="upload.php" class="footer-link">Upload Dokumen</a>
                <a href="submit_pendaftaran.php" class="footer-link">Submit</a>

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