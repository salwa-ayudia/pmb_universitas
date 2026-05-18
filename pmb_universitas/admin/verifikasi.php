<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

/* =========================
   PROSES VERIFIKASI
========================= */

/* =========================
   PROSES VERIFIKASI
========================= */

if (isset($_GET['id']) && isset($_GET['status'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // =========================
    // STATUS DIVERIFIKASI
    // =========================

    if ($status == 'diverifikasi') {

        // UPDATE STATUS PENDAFTARAN
        mysqli_query($conn, "
            UPDATE pendaftaran
            SET status_pendaftaran='seleksi'
            WHERE id_pendaftaran='$id'
        ");

        // CEK PENGUMUMAN
        $cek = mysqli_query($conn, "
            SELECT * FROM pengumuman
            WHERE id_pendaftaran='$id'
        ");

        // JIKA SUDAH ADA
        if (mysqli_num_rows($cek) > 0) {

            mysqli_query($conn, "
                UPDATE pengumuman
                SET
                    hasil='diverifikasi',
                    keterangan='Berkas telah diverifikasi admin'
                WHERE id_pendaftaran='$id'
            ");
        } else {

            // JIKA BELUM ADA
            mysqli_query($conn, "
                INSERT INTO pengumuman (
                    id_pendaftaran,
                    hasil,
                    keterangan
                ) VALUES (
                    '$id',
                    'diverifikasi',
                    'Berkas telah diverifikasi admin'
                )
            ");
        }
    }

    // =========================
    // STATUS LULUS
    // =========================

    elseif ($status == 'lulus') {

        mysqli_query($conn, "
            UPDATE pendaftaran
            SET status_pendaftaran='lulus'
            WHERE id_pendaftaran='$id'
        ");

        $cek = mysqli_query($conn, "
            SELECT * FROM pengumuman
            WHERE id_pendaftaran='$id'
        ");

        if (mysqli_num_rows($cek) > 0) {

            mysqli_query($conn, "
                UPDATE pengumuman
                SET
                    hasil='lulus',
                    keterangan='Selamat anda dinyatakan lulus'
                WHERE id_pendaftaran='$id'
            ");
        } else {

            mysqli_query($conn, "
                INSERT INTO pengumuman (
                    id_pendaftaran,
                    hasil,
                    keterangan
                ) VALUES (
                    '$id',
                    'lulus',
                    'Selamat anda dinyatakan lulus'
                )
            ");
        }
    }

    // =========================
    // STATUS DITOLAK
    // =========================

    elseif ($status == 'ditolak') {

        mysqli_query($conn, "
            UPDATE pendaftaran
            SET status_pendaftaran='tidak_lulus'
            WHERE id_pendaftaran='$id'
        ");

        $cek = mysqli_query($conn, "
            SELECT * FROM pengumuman
            WHERE id_pendaftaran='$id'
        ");

        if (mysqli_num_rows($cek) > 0) {

            mysqli_query($conn, "
                UPDATE pengumuman
                SET
                    hasil='tidak_lulus',
                    keterangan='Mohon maaf anda belum lulus'
                WHERE id_pendaftaran='$id'
            ");
        } else {

            mysqli_query($conn, "
                INSERT INTO pengumuman (
                    id_pendaftaran,
                    hasil,
                    keterangan
                ) VALUES (
                    '$id',
                    'tidak_lulus',
                    'Mohon maaf anda belum lulus'
                )
            ");
        }
    }

    header("Location: verifikasi.php?success=1");
    exit;
}

/* =========================
   FILTER
========================= */

$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';

$where = "WHERE 1=1";

if ($search != '') {
    $where .= " AND (
        users.nama_lengkap LIKE '%$search%'
        OR pendaftaran.nomor_pendaftaran LIKE '%$search%'
    )";
}

if ($filter != '') {
    $where .= " AND pendaftaran.status_pendaftaran='$filter'";
}

/* =========================
   QUERY DATA
========================= */

$query = mysqli_query($conn, "
SELECT
    users.nama_lengkap,
    users.email,
    pendaftaran.*

FROM pendaftaran

JOIN users
ON pendaftaran.id_user = users.id_user

$where

ORDER BY pendaftaran.id_pendaftaran DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Pendaftar</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            margin-bottom: 45px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 16px 18px;
            border-radius: 18px;
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
            margin-right: 14px;
            font-size: 20px;
        }

        /* =========================
           MAIN
        ========================= */

        .main-content {
            margin-left: 280px;
            padding: 35px;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            background: white;
            padding: 30px;
            border-radius: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 700;
            color: #001f54;
        }

        .page-subtitle {
            color: #666;
            margin-top: 10px;
        }

        /* =========================
           INFO CARD
        ========================= */

        .info-card {
            background: linear-gradient(135deg, #e9fff3, #f4fff9);
            border: 1px solid #c8f0d8;
            border-radius: 24px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .info-card h5 {
            font-weight: 700;
            color: #198754;
            margin-bottom: 10px;
        }

        .info-card p {
            margin: 0;
            color: #555;
        }

        /* =========================
           FILTER CARD
        ========================= */

        .filter-card {
            background: white;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            margin-bottom: 30px;
        }

        .form-control,
        .form-select {
            height: 56px;
            border-radius: 16px;
            border: 1px solid #e3e3e3;
        }

        .btn-filter {
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
            font-weight: 600;
        }

        /* =========================
           TABLE CARD
        ========================= */

        .table-card {
            background: white;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .table {
            vertical-align: middle;
        }

        .table th {
            border: none;
            color: #555;
            font-weight: 600;
        }

        .table td {
            border-color: #f1f1f1;
            padding-top: 22px;
            padding-bottom: 22px;
        }

        /* =========================
           STUDENT
        ========================= */

        .student-box {
            display: flex;
            align-items: center;
        }

        .student-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 15px;
            font-size: 20px;
        }

        .student-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .student-email {
            color: #777;
            font-size: 14px;
        }

        /* =========================
           STATUS
        ========================= */

        .badge-status{
    padding: 12px 22px;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 600;
    display: inline-block;
    min-width: 130px;
    text-align: center;
}

.draft{
    background: #fff3cd;
    color: #856404;
}

.submitted{
    background: #dbeafe;
    color: #1d4ed8;
}

.lulus{
    background: #d1fae5;
    color: #065f46;
}

.ditolak{
    background: #fde2e4;
    color: #991b1b;
}

        .selesai {
            background: #d1e7dd;
            color: #0f5132;
        }

        /* =========================
           ACTION BUTTON
        ========================= */

        .action-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: nowrap;
        }

        .action-item {
            text-align: center;
        }

        .action-btn {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: .3s;
            margin-bottom: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .action-btn:hover {
            transform: translateY(-5px);
            color: white;
        }

        .action-item small {
            font-size: 11px;
            font-weight: 600;
            color: #555;
        }

        .btn-detail {
            background: linear-gradient(135deg, #0d6efd, #001f54);
        }

        .btn-verif {
            background: linear-gradient(135deg, #198754, #48c78e);
        }

        .btn-lulus {
            background: linear-gradient(135deg, #0dcaf0, #0d6efd);
        }

        .btn-tolak {
            background: linear-gradient(135deg, #dc3545, #ff6b81);
        }

        /* =========================
           EXPLANATION
        ========================= */

        .explanation-card {
            background: white;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            margin-top: 30px;
        }

        .explanation-title {
            font-size: 28px;
            font-weight: 700;
            color: #001f54;
            margin-bottom: 25px;
        }

        .ex-box {
            border-radius: 22px;
            padding: 25px;
            height: 100%;
        }

        .ex-box h5 {
            font-weight: 700;
            margin-top: 15px;
        }

        .ex-box p {
            color: #666;
            margin-top: 12px;
            font-size: 14px;
        }

        .ex-blue {
            background: #eef5ff;
            border: 1px solid #cfe2ff;
        }

        .ex-green {
            background: #eefdf5;
            border: 1px solid #c8f0d8;
        }

        .ex-cyan {
            background: #eefcff;
            border: 1px solid #ccefff;
        }

        .ex-red {
            background: #fff1f2;
            border: 1px solid #ffd1d7;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width:992px) {

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

            <h1 class="page-title">
                Verifikasi Pendaftar
            </h1>

            <p class="page-subtitle">
                Kelola dan ubah status pendaftaran mahasiswa.
            </p>

        </div>

        <!-- INFO -->

        <div class="info-card">

            <h5>
                <i class="bi bi-info-circle-fill"></i>
                Tentang Aksi Verifikasi
            </h5>

            <p>
                Terdapat 4 aksi yang dapat dilakukan untuk mengelola status
                pendaftaran mahasiswa sesuai alur seleksi PMB.
            </p>

        </div>

        <!-- FILTER -->

        <div class="filter-card">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-lg-5">

                        <label class="fw-semibold mb-2">
                            Cari Pendaftar
                        </label>

                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama atau nomor pendaftaran..."
                            value="<?php echo $search; ?>">

                    </div>

                    <div class="col-lg-4">

                        <label class="fw-semibold mb-2">
                            Filter Status
                        </label>

                        <select name="filter" class="form-select">

                            <option value="">Semua Status</option>

                            <option value="submitted">Submitted</option>

                            <option value="diverifikasi">Diverifikasi</option>

                            <option value="lulus">Lulus</option>

                            <option value="ditolak">Ditolak</option>

                        </select>

                    </div>

                    <div class="col-lg-3 d-flex align-items-end">

                        <button class="btn btn-primary btn-filter w-100">

                            <i class="bi bi-funnel"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <!-- TABLE -->

        <div class="table-card">

            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>No Pendaftaran</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        while ($data = mysqli_fetch_assoc($query)) :

                            $status = trim(strtolower($data['status_pendaftaran']));
                        ?>

                            <tr>

                                <td>
                                    <?php echo $no++; ?>
                                </td>

                                <td>

                                    <div class="student-box">

                                        <div class="student-avatar">

                                            <?php
                                            echo strtoupper(
                                                substr($data['nama_lengkap'], 0, 1)
                                            );
                                            ?>

                                        </div>

                                        <div>

                                            <div class="student-name">
                                                <?php echo $data['nama_lengkap']; ?>
                                            </div>

                                            <div class="student-email">
                                                <?php echo $data['email']; ?>
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    <strong>
                                        <?php echo $data['nomor_pendaftaran']; ?>
                                    </strong>
                                </td>

                                <td>
                                    <?php echo $data['jurusan_pilihan']; ?>
                                </td>

                                <td>

    <?php

    $badgeClass = 'draft';
    $label = 'Draft';

    if ($status == 'seleksi') {

        $badgeClass = 'submitted';
        $label = 'Diverifikasi';

    } elseif ($status == 'submitted') {

        $badgeClass = 'submitted';
        $label = 'Submitted';

    } elseif ($status == 'tidak_lulus') {

        $badgeClass = 'ditolak';
        $label = 'Ditolak';

    } elseif ($status == 'lulus') {

        $badgeClass = 'lulus';
        $label = 'Lulus';

    } elseif ($status == 'selesai') {

        $badgeClass = 'selesai';
        $label = 'Selesai';

    }

    ?>

    <span class="badge-status <?php echo $badgeClass; ?>">
        <?php echo $label; ?>
    </span>

</td>
                                <td>

                                    <div class="action-wrapper">

                                        <!-- DETAIL -->

                                        <div class="action-item">

                                            <a href="detail_pendaftar.php?id=<?php echo $data['id_pendaftaran']; ?>"
                                                class="action-btn btn-detail">

                                                <i class="bi bi-eye-fill"></i>

                                            </a>

                                            <small>Detail</small>

                                        </div>

                                        <!-- VERIFIKASI -->

                                        <div class="action-item">

                                            <a href="verifikasi.php?id=<?php echo $data['id_pendaftaran']; ?>&status=diverifikasi"
                                                class="action-btn btn-verif"
                                                onclick="return confirm('Verifikasi mahasiswa ini?')">

                                                <i class="bi bi-patch-check-fill"></i>

                                            </a>

                                            <small>Verifikasi</small>

                                        </div>

                                        <!-- LULUS -->

                                        <div class="action-item">

                                            <a href="verifikasi.php?id=<?php echo $data['id_pendaftaran']; ?>&status=lulus"
                                                class="action-btn btn-lulus"
                                                onclick="return confirm('Luluskan mahasiswa ini?')">

                                                <i class="bi bi-trophy-fill"></i>

                                            </a>

                                            <small>Lulus</small>

                                        </div>

                                        <!-- TOLAK -->

                                        <div class="action-item">

                                            <a href="verifikasi.php?id=<?php echo $data['id_pendaftaran']; ?>&status=ditolak"
                                                class="action-btn btn-tolak"
                                                onclick="return confirm('Tolak mahasiswa ini?')">

                                                <i class="bi bi-x-circle-fill"></i>

                                            </a>

                                            <small>Tolak</small>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- EXPLANATION -->

        <div class="explanation-card">

            <h3 class="explanation-title">
                Penjelasan 4 Aksi
            </h3>

            <div class="row g-4">

                <div class="col-lg-3">

                    <div class="ex-box ex-blue">

                        <i class="bi bi-eye-fill fs-1 text-primary"></i>

                        <h5>1. Lihat Detail</h5>

                        <p>
                            Melihat informasi lengkap mahasiswa
                            termasuk biodata dan dokumen.
                        </p>

                    </div>

                </div>

                <div class="col-lg-3">

                    <div class="ex-box ex-green">

                        <i class="bi bi-patch-check-fill fs-1 text-success"></i>

                        <h5>2. Verifikasi</h5>

                        <p>
                            Mengubah status menjadi diverifikasi
                            setelah berkas dinyatakan valid.
                        </p>

                    </div>

                </div>

                <div class="col-lg-3">

                    <div class="ex-box ex-cyan">

                        <i class="bi bi-trophy-fill fs-1 text-info"></i>

                        <h5>3. Luluskan</h5>

                        <p>
                            Mengubah status menjadi lulus
                            dan diterima sebagai mahasiswa baru.
                        </p>

                    </div>

                </div>

                <div class="col-lg-3">

                    <div class="ex-box ex-red">

                        <i class="bi bi-x-circle-fill fs-1 text-danger"></i>

                        <h5>4. Tolak</h5>

                        <p>
                            Mengubah status menjadi ditolak
                            apabila tidak memenuhi syarat.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>