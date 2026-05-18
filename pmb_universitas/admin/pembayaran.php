<?php
session_start();
include '../config/koneksi.php';


// =========================
// CEK LOGIN ADMIN
// =========================

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}


// =========================
// PROSES VERIFIKASI
// =========================

if (isset($_GET['id']) && isset($_GET['status'])) {

    $id_daftar_ulang = $_GET['id'];
    $status = $_GET['status'];

    if ($status == 'valid' || $status == 'ditolak') {

        $ambil = mysqli_query($conn, "
        SELECT * FROM daftar_ulang
        WHERE id_daftar_ulang = '$id_daftar_ulang'
        ");

        $data_daftar = mysqli_fetch_assoc($ambil);

        if ($data_daftar) {

            $id_pendaftaran = $data_daftar['id_pendaftaran'];

            mysqli_query($conn, "
            UPDATE daftar_ulang
            SET
                status_verifikasi = '$status',
                verified_by = '" . $_SESSION['id_user'] . "'
            WHERE id_daftar_ulang = '$id_daftar_ulang'
            ");

            if ($status == 'valid') {

                mysqli_query($conn, "
                UPDATE pendaftaran
                SET status_pendaftaran = 'selesai'
                WHERE id_pendaftaran = '$id_pendaftaran'
                ");
            }

            echo "
            <script>
                alert('Status pembayaran berhasil diperbarui!');
                window.location='pembayaran.php';
            </script>
            ";
            exit;
        }
    }
}


// =========================
// AMBIL DATA
// =========================

$query = mysqli_query($conn, "
SELECT
    daftar_ulang.*,
    pendaftaran.nomor_pendaftaran,
    pendaftaran.jurusan_pilihan,
    users.nama_lengkap,
    users.email

FROM daftar_ulang

JOIN pendaftaran
ON daftar_ulang.id_pendaftaran = pendaftaran.id_pendaftaran

JOIN users
ON pendaftaran.id_user = users.id_user

ORDER BY daftar_ulang.created_at DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran Daftar Ulang</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f7fb;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #001f54, #0d6efd);
            position: fixed;
            left: 0;
            top: 0;
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
            padding: 16px 18px;
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            border-radius: 15px;
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

        .main-content {
            margin-left: 280px;
            padding: 35px;
        }

        /* =========================
           MAIN
        ========================= */

        .main-content {
            margin-left: 260px;
            padding: 35px;
        }

        .topbar {
            background: white;
            border-radius: 22px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .topbar-title {
            font-size: 32px;
            font-weight: 700;
            color: #001f54;
        }

        .topbar-subtitle {
            color: #6c757d;
            margin-top: 8px;
        }

        .card-custom {
            background: white;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        /* =========================
           TABLE
        ========================= */

        .table thead {
            background: #0d6efd;
            color: white;
        }

        .table thead th {
            border: none;
            padding: 16px;
        }

        .table tbody td {
            padding: 18px 16px;
            vertical-align: middle;
        }

        .proof-img {
            width: 85px;
            height: 85px;
            object-fit: cover;
            border-radius: 14px;
            border: 3px solid #eef3ff;
        }

        /* =========================
           BADGE
        ========================= */

        .badge {
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .badge-valid {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-action {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-success {
            background: #198754;
            border: none;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
        }

        .pdf-preview {
            width: 85px;
            height: 85px;
            border-radius: 14px;
            background: #fff5f5;
            border: 3px solid #ffe3e3;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            color: #dc3545;
            font-weight: 700;
        }

        .pdf-preview i {
            font-size: 30px;
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

    <!-- SIDEBAR -->

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

        <a href="verifikasi.php" class="menu-link">
            <i class="bi bi-patch-check-fill"></i>
            Verifikasi
        </a>

        <a href="pembayaran.php" class="menu-link active">
            <i class="bi bi-wallet2"></i>
            Pembayaran
        </a>

        <a href="../logout.php" class="menu-link">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </div>

    <a href="../logout.php" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

    </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div class="topbar-title">
                Verifikasi Pembayaran
            </div>

            <div class="topbar-subtitle">
                Kelola pembayaran daftar ulang mahasiswa baru.
            </div>

        </div>

        <!-- CARD -->

        <div class="card-custom">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>No Pendaftaran</th>
                            <th>Jurusan</th>
                            <th>Bukti</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $no = 1; ?>

                        <?php while ($data = mysqli_fetch_assoc($query)) : ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td>

                                    <strong>
                                        <?= $data['nama_lengkap']; ?>
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        <?= $data['email']; ?>
                                    </small>

                                </td>

                                <td>
                                    <?= $data['nomor_pendaftaran']; ?>
                                </td>

                                <td>
                                    <?= $data['jurusan_pilihan']; ?>
                                </td>

                                <td>

                                    <?php if ($data['bukti_pembayaran']) : ?>

                                        <?php
                                        $file = $data['bukti_pembayaran'];
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        ?>

                                        <a href="../assets/bukti_pembayaran/<?= $file; ?>"
                                            target="_blank">

                                            <?php if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') : ?>

                                                <img src="../assets/bukti_pembayaran/<?= $file; ?>"
                                                    class="proof-img">

                                            <?php elseif ($ext == 'pdf') : ?>

                                                <div class="pdf-preview">

                                                    <i class="bi bi-file-earmark-pdf-fill"></i>

                                                    <span>PDF</span>

                                                </div>

                                            <?php else : ?>

                                                <div class="pdf-preview">

                                                    <i class="bi bi-file-earmark-fill"></i>

                                                    <span>FILE</span>

                                                </div>

                                            <?php endif; ?>

                                        </a>

                                    <?php else : ?>

                                        <span class="text-muted">
                                            Tidak ada file
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= date('d M Y', strtotime($data['tanggal_bayar'])); ?>
                                </td>

                                <td>
                                    Rp <?= number_format($data['nominal'], 0, ',', '.'); ?>
                                </td>

                                <td>

                                    <?php if ($data['status_verifikasi'] == 'menunggu') : ?>

                                        <span class="badge badge-menunggu">
                                            Menunggu
                                        </span>

                                    <?php elseif ($data['status_verifikasi'] == 'valid') : ?>

                                        <span class="badge badge-valid">
                                            Valid
                                        </span>

                                    <?php else : ?>

                                        <span class="badge badge-ditolak">
                                            Ditolak
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?php if ($data['status_verifikasi'] == 'menunggu') : ?>

                                        <div class="d-flex gap-2">

                                            <a href="?id=<?= $data['id_daftar_ulang']; ?>&status=valid"
                                                class="btn btn-success btn-action">

                                                <i class="bi bi-check-lg"></i>

                                            </a>

                                            <a href="?id=<?= $data['id_daftar_ulang']; ?>&status=ditolak"
                                                class="btn btn-danger btn-action">

                                                <i class="bi bi-x-lg"></i>

                                            </a>

                                        </div>

                                    <?php else : ?>

                                        <span class="text-muted fw-semibold">
                                            Tidak ada aksi
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>