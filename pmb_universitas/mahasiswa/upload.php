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

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Dokumen</title>

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
            font-size: 40px;
            font-weight: 700;
        }

        .hero-subtitle{
            margin-top: 15px;
            opacity: .9;
        }

        .upload-wrapper{
            margin-top: -40px;
        }

        .upload-card{
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,.08);
        }

        .section-title{
            font-weight: 700;
            color: #001f54;
            margin-bottom: 30px;
        }

        .upload-box{
            border: 2px dashed #d8e2f0;
            border-radius: 25px;
            padding: 30px;
            text-align: center;
            transition: .3s;
            height: 100%;
            background: #fafcff;
        }

        .upload-box:hover{
            border-color: #0d6efd;
            transform: translateY(-5px);
        }

        .upload-icon{
            font-size: 55px;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .upload-box h5{
            font-weight: 600;
            margin-bottom: 15px;
        }

        .form-control{
            border-radius: 14px;
            padding: 12px;
        }

        .btn-upload{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
            border-radius: 14px;
            height: 55px;
            font-weight: 600;
            padding: 0 40px;
        }

        .preview-file{
            margin-top: 15px;
            background: #eef4ff;
            padding: 10px;
            border-radius: 12px;
            font-size: 14px;
            word-break: break-all;
        }

        .info-card{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            color: white;
            border-radius: 25px;
            padding: 30px;
            height: 100%;
        }

        .info-card i{
            font-size: 50px;
            margin-bottom: 20px;
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
                    <a class="nav-link active" href="upload.php">Upload Dokumen</a>
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
                    Upload Dokumen Persyaratan
                </h1>

                <p class="hero-subtitle">
                    Upload seluruh dokumen yang dibutuhkan
                    untuk melanjutkan proses pendaftaran mahasiswa baru.
                </p>

            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0">

                <img src="https://cdn-icons-png.flaticon.com/512/4727/4727424.png"
                     width="280"
                     class="img-fluid">

            </div>

        </div>

    </div>

</section>

<div class="container upload-wrapper pb-5">

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="upload-card">

                <h3 class="section-title">
                    Upload Dokumen
                </h3>

                <?php if(isset($_GET['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Dokumen berhasil diupload.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="proses_upload.php"
                      method="POST"
                      enctype="multipart/form-data">

                    <div class="row g-4">

                        <!-- FOTO -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>

                                <h5>Pas Foto</h5>

                                <input type="file"
                                       name="foto"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['foto'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['foto']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- KTP -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-person-vcard-fill"></i>
                                </div>

                                <h5>KTP</h5>

                                <input type="file"
                                       name="ktp"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['ktp'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['ktp']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- KK -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-people-fill"></i>
                                </div>

                                <h5>Kartu Keluarga</h5>

                                <input type="file"
                                       name="kartu_keluarga"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['kartu_keluarga'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['kartu_keluarga']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- IJAZAH -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-award-fill"></i>
                                </div>

                                <h5>Ijazah</h5>

                                <input type="file"
                                       name="ijazah"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['ijazah'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['ijazah']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- RAPORT -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>

                                <h5>Raport</h5>

                                <input type="file"
                                       name="raport"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['raport'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['raport']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- SERTIFIKAT -->
                        <div class="col-md-6">

                            <div class="upload-box">

                                <div class="upload-icon">
                                    <i class="bi bi-patch-check-fill"></i>
                                </div>

                                <h5>Sertifikat</h5>

                                <input type="file"
                                       name="sertifikat"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.pdf">

                                <?php if(!empty($dokumen['sertifikat'])) : ?>
                                    <div class="preview-file">
                                        <i class="bi bi-file-earmark-check-fill text-success"></i>
                                        <?= $dokumen['sertifikat']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <div class="mt-5">

                        <button type="submit" class="btn btn-primary btn-upload">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            Upload Dokumen
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="info-card">

                <i class="bi bi-info-circle-fill"></i>

                <h3 class="fw-bold mb-3">
                    Informasi Upload
                </h3>

                <p>
                    Pastikan dokumen yang diupload jelas,
                    valid, dan sesuai persyaratan kampus.
                </p>

                <hr>

                <p>
                    Format file yang diperbolehkan:
                    JPG, PNG, PDF.
                </p>

                <hr>

                <p>
                    Maksimal ukuran file:
                    2MB per dokumen.
                </p>

                <hr>

                <p class="mb-0">
                    Setelah upload selesai,
                    Anda dapat melanjutkan
                    proses submit pendaftaran.
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
                <a href="pengumuman.php" class="footer-link">Pengumuman</a>

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