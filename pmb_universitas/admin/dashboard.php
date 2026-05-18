<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

/* =========================
   TOTAL DATA
========================= */

$totalPendaftar = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM pendaftaran")
);

$totalSubmitted = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM pendaftaran 
    WHERE status_pendaftaran='submitted'")
);

$totalLulus = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM pendaftaran 
    WHERE status_pendaftaran='lulus'")
);

$totalDitolak = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM pendaftaran 
    WHERE status_pendaftaran='ditolak'")
);

/* =========================
   DATA TERBARU
========================= */

$queryLatest = mysqli_query($conn, "
SELECT 
    pendaftaran.*,
    users.nama_lengkap
FROM pendaftaran
JOIN users ON pendaftaran.id_user = users.id_user
ORDER BY pendaftaran.id_pendaftaran DESC
LIMIT 5
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

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

        .sidebar{
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg,#001f54,#0d6efd);
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
            color: white;
            z-index: 999;
        }

        .brand{
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .menu-link{
            display: flex;
            align-items: center;
            padding: 16px 18px;
            color: rgba(255,255,255,.85);
            text-decoration: none;
            border-radius: 15px;
            margin-bottom: 12px;
            transition: .3s;
            font-weight: 500;
        }

        .menu-link:hover,
        .menu-link.active{
            background: rgba(255,255,255,.15);
            color: white;
        }

        .menu-link i{
            margin-right: 12px;
            font-size: 20px;
        }

        .main-content{
            margin-left: 280px;
            padding: 35px;
        }

        .topbar{
            background: white;
            border-radius: 25px;
            padding: 25px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            margin-bottom: 35px;
        }

        .welcome-title{
            font-size: 30px;
            font-weight: 700;
            color: #001f54;
        }

        .welcome-subtitle{
            color: #777;
            margin-top: 8px;
        }

        .dashboard-card{
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            transition: .3s;
            height: 100%;
        }

        .dashboard-card:hover{
            transform: translateY(-5px);
        }

        .card-icon{
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            color: white;
            margin-bottom: 20px;
        }

        .bg-blue{
            background: linear-gradient(135deg,#0d6efd,#4a90ff);
        }

        .bg-green{
            background: linear-gradient(135deg,#198754,#48c78e);
        }

        .bg-red{
            background: linear-gradient(135deg,#dc3545,#ff6b81);
        }

        .bg-orange{
            background: linear-gradient(135deg,#fd7e14,#ffb347);
        }

        .dashboard-card h5{
            color: #666;
            margin-bottom: 10px;
        }

        .dashboard-card h2{
            font-weight: 700;
            color: #001f54;
        }

        .section-title{
            font-size: 28px;
            font-weight: 700;
            color: #001f54;
            margin-bottom: 25px;
        }

        .table-wrapper{
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
        }

        .table{
            vertical-align: middle;
        }

        .table th{
            border: none;
            color: #555;
            font-weight: 600;
        }

        .table td{
            border-color: #f1f1f1;
        }

        .badge-status{
            padding: 10px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-draft{
            background: #fff3cd;
            color: #856404;
        }

        .badge-submitted{
            background: #cfe2ff;
            color: #084298;
        }

        .badge-lulus{
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-ditolak{
            background: #f8d7da;
            color: #842029;
        }

        .btn-detail{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 500;
        }

        .admin-profile{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            border-radius: 25px;
            padding: 30px;
            color: white;
            margin-top: 35px;
        }

        .admin-avatar{
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin-bottom: 20px;
        }

        @media(max-width: 992px){

            .sidebar{
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content{
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

    <a href="dashboard.php" class="menu-link active">
        <i class="bi bi-grid-fill"></i>
        Dashboard
    </a>

    <a href="verifikasi.php" class="menu-link">
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

        <div class="row align-items-center">

            <div class="col-lg-8">

                <h1 class="welcome-title">
                    Dashboard Admin 👋
                </h1>

                <p class="welcome-subtitle">
                    Kelola data pendaftaran mahasiswa baru
                    secara cepat dan terintegrasi.
                </p>

            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                <h5 class="fw-bold mb-1">
                    <?php echo $_SESSION['nama_lengkap']; ?>
                </h5>

                <span class="text-muted">
                    Administrator PMB
                </span>

            </div>

        </div>

    </div>

    <!-- STATISTIK -->

    <div class="row g-4 mb-5">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon bg-blue">
                    <i class="bi bi-people-fill"></i>
                </div>

                <h5>Total Pendaftar</h5>

                <h2>
                    <?php echo $totalPendaftar; ?>
                </h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon bg-orange">
                    <i class="bi bi-send-check-fill"></i>
                </div>

                <h5>Submitted</h5>

                <h2>
                    <?php echo $totalSubmitted; ?>
                </h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon bg-green">
                    <i class="bi bi-trophy-fill"></i>
                </div>

                <h5>Lulus</h5>

                <h2>
                    <?php echo $totalLulus; ?>
                </h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon bg-red">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

                <h5>Ditolak</h5>

                <h2>
                    <?php echo $totalDitolak; ?>
                </h2>

            </div>

        </div>

    </div>

    <!-- DATA TERBARU -->

    <h3 class="section-title">
        Pendaftar Terbaru
    </h3>

    <div class="table-wrapper">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Pendaftaran</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while($data = mysqli_fetch_assoc($queryLatest)) :

                        $status = $data['status_pendaftaran'];

                    ?>

                    <tr>

                        <td><?php echo $no++; ?></td>

                        <td>
                            <strong>
                                <?php echo $data['nama_lengkap']; ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo $data['nomor_pendaftaran']; ?>
                        </td>

                        <td>
                            <?php echo $data['jurusan_pilihan']; ?>
                        </td>

                        <td>

                            <?php if($status == 'draft') : ?>

                                <span class="badge-status badge-draft">
                                    Draft
                                </span>

                            <?php elseif($status == 'submitted') : ?>

                                <span class="badge-status badge-submitted">
                                    Submitted
                                </span>

                            <?php elseif($status == 'lulus') : ?>

                                <span class="badge-status badge-lulus">
                                    Lulus
                                </span>

                            <?php else : ?>

                                <span class="badge-status badge-ditolak">
                                    Ditolak
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a href="detail_pendaftar.php?id=<?php echo $data['id_pendaftaran']; ?>"
                               class="btn btn-primary btn-detail">

                                <i class="bi bi-eye-fill"></i>
                                Detail

                            </a>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- ADMIN PROFILE -->

    <div class="admin-profile">

        <div class="admin-avatar">
            <i class="bi bi-person-fill"></i>
        </div>

        <h3 class="fw-bold">
            <?php echo $_SESSION['nama_lengkap']; ?>
        </h3>

        <p class="mb-0 mt-2">
            Kelola seluruh proses penerimaan mahasiswa baru
            dengan sistem PMB digital modern.
        </p>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>