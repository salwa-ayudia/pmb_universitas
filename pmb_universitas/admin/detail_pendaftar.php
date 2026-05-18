<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: verifikasi.php");
    exit;
}

$id = $_GET['id'];

/* =========================
   QUERY DATA
========================= */

$query = mysqli_query($conn, "
SELECT 
    users.*,
    pendaftaran.*,
    dokumen.*

FROM pendaftaran

JOIN users 
ON pendaftaran.id_user = users.id_user

LEFT JOIN dokumen
ON pendaftaran.id_pendaftaran = dokumen.id_pendaftaran

WHERE pendaftaran.id_pendaftaran='$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: verifikasi.php");
    exit;
}

$status = $data['status_pendaftaran'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pendaftar</title>

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

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #001f54, #0d6efd);
            padding: 30px 20px;
            color: white;
            z-index: 999;
        }

        .brand {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 15px 18px;
            border-radius: 16px;
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            margin-bottom: 12px;
            transition: .3s;
            font-weight: 500;
        }

        .menu-link:hover,
        .menu-link.active {
            background: rgba(255, 255, 255, .15);
            color: white;
        }

        .menu-link i {
            margin-right: 12px;
            font-size: 20px;
        }

        /* =========================
           MAIN
        ========================= */

        .main-content {
            margin-left: 280px;
            padding: 35px;
        }

        .topbar {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            margin-bottom: 35px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #001f54;
        }

        .page-subtitle {
            color: #777;
            margin-top: 10px;
        }

        /* =========================
           CARD
        ========================= */

        .detail-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            margin-bottom: 35px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #001f54;
            margin-bottom: 25px;
        }

        .profile-wrapper {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 42px;
            font-weight: 700;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            color: #001f54;
        }

        .profile-email {
            color: #777;
            margin-top: 8px;
        }

        /* =========================
           INFO BOX
        ========================= */

        .info-box {
            background: #f8fbff;
            border-radius: 18px;
            padding: 20px;
            height: 100%;
        }

        .info-label {
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        .info-value {
            font-weight: 600;
            color: #001f54;
            word-break: break-word;
        }

        /* =========================
           STATUS BADGE
        ========================= */

        .badge-status {
            padding: 10px 18px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-draft {
            background: #fff3cd;
            color: #856404;
        }

        .badge-submitted {
            background: #cfe2ff;
            color: #084298;
        }

        .badge-lulus {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        /* =========================
           DOCUMENT CARD
        ========================= */

        .doc-card {
            background: #f8fbff;
            border-radius: 20px;
            padding: 20px;
            transition: .3s;
            height: 100%;
        }

        .doc-card:hover {
            transform: translateY(-4px);
        }

        .doc-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .doc-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: #001f54;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-custom {
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            border: none;
        }

        .btn-verif {
            background: linear-gradient(135deg, #198754, #48c78e);
            color: white;
        }

        .btn-tolak {
            background: linear-gradient(135deg, #dc3545, #ff6b81);
            color: white;
        }

        .btn-lulus {
            background: linear-gradient(135deg, #0d6efd, #001f54);
            color: white;
        }

        .btn-download {
            border-radius: 12px;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 500;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 992px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="brand">
            <i class="bi bi-mortarboard-fill"></i>
            PMB Admin
        </div>

        <a href="dashboard.php" class="menu-link">
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href="verifikasi.php" class="menu-link active">
            <i class="bi bi-patch-check-fill"></i>
            Verifikasi
        </a>

        <a href="pembayaran.php" class="menu-link">
            <i class="bi bi-wallet2"></i>
            Pembayaran
        </a>

        <a href="logout.php" class="menu-link">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h1 class="page-title">
                        Detail Pendaftar
                    </h1>

                    <p class="page-subtitle">
                        Informasi lengkap mahasiswa pendaftar PMB.
                    </p>

                </div>

                <a href="verifikasi.php"
                    class="btn btn-dark btn-custom mt-3 mt-lg-0">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>

        <!-- PROFILE -->

        <div class="detail-card">

            <div class="profile-wrapper">

                <div class="profile-avatar">

                    <?php echo strtoupper(substr($data['nama_lengkap'], 0, 1)); ?>

                </div>

                <div>

                    <div class="profile-name">
                        <?php echo $data['nama_lengkap']; ?>
                    </div>

                    <div class="profile-email">
                        <?php echo $data['email']; ?>
                    </div>

                    <div class="mt-3">

                        <?php if ($status == 'draft') : ?>

                            <span class="badge-status badge-draft">
                                Draft
                            </span>

                        <?php elseif ($status == 'submitted') : ?>

                            <span class="badge-status badge-submitted">
                                Submitted
                            </span>

                        <?php elseif ($status == 'lulus') : ?>

                            <span class="badge-status badge-lulus">
                                Lulus
                            </span>

                        <?php elseif ($status == 'ditolak') : ?>

                            <span class="badge-status badge-ditolak">
                                Ditolak
                            </span>

                        <?php else : ?>

                            <span class="badge-status badge-draft">
                                Belum Diproses
                            </span>


                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- DATA PENDAFTARAN -->

        <div class="detail-card">

            <h3 class="section-title">
                Data Pendaftaran
            </h3>

            <div class="row g-4">

                <div class="col-lg-4">
                    <div class="info-box">
                        <div class="info-label">Nomor Pendaftaran</div>
                        <div class="info-value">
                            <?php echo $data['nomor_pendaftaran']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="info-box">
                        <div class="info-label">Jurusan Pilihan</div>
                        <div class="info-value">
                            <?php echo $data['jurusan_pilihan']; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="info-box">
                        <div class="info-label">Tanggal Daftar</div>
                        <div class="info-value">
                            <?php
                            echo date(
                                'd M Y',
                                strtotime($data['tanggal_daftar'])
                            );
                            ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- BIODATA -->

        <div class="detail-card">

            <h3 class="section-title">
                Biodata Mahasiswa
            </h3>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">NIK</div>
                        <div class="info-value">
                            <?php echo $data['nik'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            <?php
                            if ($data['jenis_kelamin'] == 'L') {
                                echo 'Laki-laki';
                            } elseif ($data['jenis_kelamin'] == 'P') {
                                echo 'Perempuan';
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">Tempat Lahir</div>
                        <div class="info-value">
                            <?php echo $data['tempat_lahir'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">
                            <?php echo $data['tanggal_lahir'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">No HP</div>
                        <div class="info-value">
                            <?php echo $data['no_hp'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-box">
                        <div class="info-label">Sekolah Asal</div>
                        <div class="info-value">
                            <?php echo $data['asal_sekolah'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="info-box">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">
                            <?php echo $data['alamat'] ?? '-'; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- DOKUMEN -->

        <div class="detail-card">

            <h3 class="section-title">
                Dokumen Upload
            </h3>

            <div class="row g-4">

                <?php

                $dokumenList = [
                    'foto' => 'Pas Foto',
                    'ktp' => 'KTP',
                    'kartu_keluarga' => 'Kartu Keluarga',
                    'ijazah' => 'Ijazah',
                    'raport' => 'Raport',
                    'sertifikat' => 'Sertifikat'
                ];

                foreach ($dokumenList as $field => $label):

                ?>

                    <div class="col-lg-4 col-md-6">

                        <div class="doc-card">

                            <div class="doc-icon">
                                <i class="bi bi-file-earmark-fill"></i>
                            </div>

                            <div class="doc-title">
                                <?php echo $label; ?>
                            </div>

                            <?php if (!empty($data[$field])) : ?>

                                <p class="text-success fw-semibold">
                                    Dokumen tersedia
                                </p>

                                <a href="../uploads/<?php echo $data[$field]; ?>"
                                    target="_blank"
                                    class="btn btn-primary btn-download">

                                    <i class="bi bi-download"></i>
                                    Lihat Dokumen

                                </a>

                            <?php else : ?>

                                <p class="text-danger fw-semibold">
                                    Belum upload
                                </p>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>