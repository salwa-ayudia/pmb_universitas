<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'mahasiswa'){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM pendaftaran 
WHERE id_user='$id_user'");

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Biodata Mahasiswa</title>

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

        .form-wrapper{
            margin-top: -40px;
        }

        .form-card{
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

        .form-label{
            font-weight: 500;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select{
            height: 55px;
            border-radius: 14px;
            border: 1px solid #dfe3ea;
        }

        textarea.form-control{
            height: auto;
        }

        .form-control:focus,
        .form-select:focus{
            border-color: #0d6efd;
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
        }

        .btn-save{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
            border-radius: 14px;
            height: 55px;
            font-weight: 600;
            padding: 0 40px;
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
                    <a class="nav-link active" href="biodata.php">Biodata</a>
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
                    Lengkapi Biodata Pendaftaran
                </h1>

                <p class="hero-subtitle">
                    Isi seluruh data dengan benar dan lengkap
                    untuk melanjutkan proses penerimaan mahasiswa baru.
                </p>

            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0">

                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                     width="260"
                     class="img-fluid">

            </div>

        </div>

    </div>

</section>

<div class="container form-wrapper pb-5">

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="form-card">

                <h3 class="section-title">
                    Form Biodata Mahasiswa
                </h3>

                <?php if(isset($_GET['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Biodata berhasil disimpan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="proses_biodata.php" method="POST">

                    <div class="row">

                        <div class="col-md-6 mb-4">
                            <label class="form-label">NIK</label>
                            <input type="text"
                                   name="nik"
                                   class="form-control"
                                   value="<?= $data['nik'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">NISN</label>
                            <input type="text"
                                   name="nisn"
                                   class="form-control"
                                   value="<?= $data['nisn'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text"
                                   name="tempat_lahir"
                                   class="form-control"
                                   value="<?= $data['tempat_lahir'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date"
                                   name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= $data['tanggal_lahir'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Jenis Kelamin</label>

                            <select name="jenis_kelamin" class="form-select" required>

                                <option value="">-- Pilih Jenis Kelamin --</option>

                                <option value="L"
                                <?= (isset($data['jenis_kelamin']) && $data['jenis_kelamin']=='L') ? 'selected' : '' ?>>
                                    Laki-laki
                                </option>

                                <option value="P"
                                <?= (isset($data['jenis_kelamin']) && $data['jenis_kelamin']=='P') ? 'selected' : '' ?>>
                                    Perempuan
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Agama</label>

                            <select name="agama" class="form-select" required>

                                <option value="">-- Pilih Agama --</option>

                                <?php
                                $agama = ['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'];

                                foreach($agama as $a){
                                ?>

                                <option value="<?= $a ?>"
                                <?= (isset($data['agama']) && $data['agama']==$a) ? 'selected' : '' ?>>
                                    <?= $a ?>
                                </option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label">Alamat</label>

                            <textarea name="alamat"
                                      class="form-control"
                                      rows="4"
                                      required><?= $data['alamat'] ?? '' ?></textarea>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Asal Sekolah</label>

                            <input type="text"
                                   name="asal_sekolah"
                                   class="form-control"
                                   value="<?= $data['asal_sekolah'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tahun Lulus</label>

                            <input type="number"
                                   name="tahun_lulus"
                                   class="form-control"
                                   value="<?= $data['tahun_lulus'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Nama Ayah</label>

                            <input type="text"
                                   name="nama_ayah"
                                   class="form-control"
                                   value="<?= $data['nama_ayah'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Nama Ibu</label>

                            <input type="text"
                                   name="nama_ibu"
                                   class="form-control"
                                   value="<?= $data['nama_ibu'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">No HP Orang Tua</label>

                            <input type="text"
                                   name="no_hp_ortu"
                                   class="form-control"
                                   value="<?= $data['no_hp_ortu'] ?? '' ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Jurusan Pilihan</label>

                            <select name="jurusan_pilihan" class="form-select" required>

                                <option value="">-- Pilih Jurusan --</option>

                                <option value="Teknik Informatika"
                                <?= (isset($data['jurusan_pilihan']) && $data['jurusan_pilihan']=='Teknik Informatika') ? 'selected' : '' ?>>
                                    Teknik Informatika
                                </option>

                                <option value="Sistem Informasi"
                                <?= (isset($data['jurusan_pilihan']) && $data['jurusan_pilihan']=='Sistem Informasi') ? 'selected' : '' ?>>
                                    Sistem Informasi
                                </option>

                                <option value="Manajemen"
                                <?= (isset($data['jurusan_pilihan']) && $data['jurusan_pilihan']=='Manajemen') ? 'selected' : '' ?>>
                                    Manajemen
                                </option>

                                <option value="Akuntansi"
                                <?= (isset($data['jurusan_pilihan']) && $data['jurusan_pilihan']=='Akuntansi') ? 'selected' : '' ?>>
                                    Akuntansi
                                </option>

                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary btn-save">
                        Simpan Biodata
                    </button>

                </form>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="info-card">

                <i class="bi bi-info-circle-fill"></i>

                <h3 class="fw-bold mb-3">
                    Informasi Penting
                </h3>

                <p>
                    Pastikan seluruh data yang Anda input
                    sudah benar dan sesuai dokumen resmi.
                </p>

                <hr>

                <p>
                    Setelah biodata selesai diisi,
                    Anda dapat melanjutkan ke tahap
                    upload dokumen persyaratan.
                </p>

                <hr>

                <p class="mb-0">
                    Gunakan data yang aktif dan valid
                    agar proses verifikasi berjalan lancar.
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