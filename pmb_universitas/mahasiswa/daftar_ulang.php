<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'mahasiswa'){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
SELECT *
FROM pendaftaran
WHERE id_user='$id_user'
");

$data = mysqli_fetch_assoc($query);

$status = $data['status_pendaftaran'] ?? 'draft';

if($status != 'lulus'){
    header("Location: pengumuman.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Ulang PMB</title>

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
            padding: 70px 0 140px;
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
            max-width: 700px;
        }

        /* =========================
           CONTENT
        ========================= */

        .content-wrapper{
            margin-top: -90px;
            position: relative;
            z-index: 5;
        }

        .main-card{
            background: white;
            border-radius: 35px;
            padding: 45px;
            box-shadow: 0 20px 45px rgba(0,0,0,.08);
            margin-bottom: 30px;
        }

        .section-title{
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #001f54;
        }

        .section-subtitle{
            color: #6c757d;
            margin-bottom: 35px;
        }

        .payment-card{
            border: 2px dashed #dce6ff;
            border-radius: 25px;
            padding: 30px;
            transition: .3s;
            height: 100%;
        }

        .payment-card:hover{
            transform: translateY(-5px);
            border-color: #0d6efd;
        }

        .payment-icon{
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg,#0d6efd,#4dabff);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .payment-title{
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .payment-desc{
            color: #6c757d;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .price-box{
            background: #f8fbff;
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .price-label{
            font-size: 14px;
            color: #6c757d;
        }

        .price-value{
            font-size: 28px;
            font-weight: 700;
            color: #0d6efd;
        }

        .bank-box{
            background: #f8f9fa;
            border-radius: 18px;
            padding: 22px;
        }

        .bank-item{
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .bank-item:last-child{
            margin-bottom: 0;
        }

        .bank-label{
            color: #6c757d;
        }

        .bank-value{
            font-weight: 600;
            color: #001f54;
        }

        .upload-box{
            border: 2px dashed #0d6efd;
            border-radius: 25px;
            padding: 35px;
            text-align: center;
            background: #f8fbff;
        }

        .upload-icon{
            font-size: 55px;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .btn-primary-custom{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            border: none;
            border-radius: 14px;
            padding: 14px 28px;
            font-weight: 600;
        }

        .btn-primary-custom:hover{
            opacity: .95;
        }

        .info-alert{
            background: linear-gradient(135deg,#e8f1ff,#f5f9ff);
            border: none;
            border-radius: 20px;
            padding: 20px;
        }

        footer{
            padding: 30px 0;
            text-align: center;
            color: #6c757d;
        }

        @media(max-width:768px){

            .hero-title{
                font-size: 34px;
            }

            .main-card{
                padding: 28px;
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
                        Upload
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
        <div class="container text-center">

            <h1 class="hero-title">
                Daftar Ulang Mahasiswa Baru
            </h1>

            <p class="hero-subtitle mx-auto">
                Selamat kamu telah dinyatakan lulus seleksi PMB. Silakan lakukan pembayaran daftar ulang untuk menyelesaikan proses registrasi mahasiswa baru.
            </p>

        </div>
    </section>

    <!-- CONTENT -->

    <div class="container content-wrapper">

        <div class="main-card">

            <h2 class="section-title">
                Informasi Pembayaran
            </h2>

            <p class="section-subtitle">
                Berikut detail biaya daftar ulang dan rekening tujuan pembayaran.
            </p>

            <div class="row g-4">

                <div class="col-lg-6">

                    <div class="payment-card">

                        <div class="payment-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <h4 class="payment-title">
                            Biaya Daftar Ulang
                        </h4>

                        <p class="payment-desc">
                            Pembayaran dilakukan maksimal 7 hari setelah pengumuman kelulusan.
                        </p>

                        <div class="price-box">
                            <div class="price-label">
                                Total Pembayaran
                            </div>
                            <div class="price-value">
                                Rp 2.500.000
                            </div>
                        </div>

                        <div class="alert info-alert mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Simpan bukti pembayaran untuk proses verifikasi oleh panitia PMB.
                        </div>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="payment-card">

                        <div class="payment-icon">
                            <i class="bi bi-bank"></i>
                        </div>

                        <h4 class="payment-title">
                            Rekening Pembayaran
                        </h4>

                        <p class="payment-desc">
                            Transfer pembayaran ke rekening resmi universitas berikut.
                        </p>

                        <div class="bank-box">

                            <div class="bank-item">
                                <span class="bank-label">Bank</span>
                                <span class="bank-value">Bank BCA</span>
                            </div>

                            <div class="bank-item">
                                <span class="bank-label">No Rekening</span>
                                <span class="bank-value">1234567890</span>
                            </div>

                            <div class="bank-item">
                                <span class="bank-label">Atas Nama</span>
                                <span class="bank-value">Universitas PMB</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="main-card">

            <h2 class="section-title">
                Upload Bukti Pembayaran
            </h2>

            <p class="section-subtitle">
                Upload file bukti transfer pembayaran daftar ulang.
            </p>

            <form action="proses_daftar_ulang.php" method="POST" enctype="multipart/form-data">

                <div class="upload-box">

                    <div class="upload-icon">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>

                    <h4 class="mb-3 fw-semibold">
                        Upload Bukti Pembayaran
                    </h4>

                    <p class="text-muted mb-4">
                        Format file JPG, PNG, atau PDF maksimal 2MB.
                    </p>

                    <input type="file"
                           name="bukti_pembayaran"
                           class="form-control mb-4"
                           required>

                    <button type="submit" class="btn btn-primary-custom text-white">
                        <i class="bi bi-send-check-fill me-2"></i>
                        Kirim Bukti Pembayaran
                    </button>

                </div>

            </form>

        </div>

    </div>

    <footer>
        © 2026 PMB Universitas — Sistem Penerimaan Mahasiswa Baru
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>