<?php
session_start();


if(isset($_SESSION['login']) && $_SESSION['role'] == 'mahasiswa'){

    header("Location: /pmb_universitas/mahasiswa/dashboard.php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login PMB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            overflow-x: hidden;
        }

        .login-wrapper{
            min-height: 100vh;
        }

        .login-left{
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h1{
            font-size: 48px;
            font-weight: 700;
        }

        .login-left p{
            margin-top: 20px;
            opacity: .9;
        }

        .feature-box{
            background: rgba(255,255,255,.1);
            border-radius: 20px;
            padding: 18px;
            margin-top: 20px;
            backdrop-filter: blur(10px);
        }

        .login-card{
            background: white;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 15px 40px rgba(0,0,0,.15);
        }

        .login-card h2{
            font-weight: 700;
            color: #001f54;
        }

        .form-control{
            height: 55px;
            border-radius: 14px;
        }

        .btn-login{
            height: 55px;
            border-radius: 14px;
            font-weight: 600;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
        }

        .input-group-text{
            cursor: pointer;
        }

        @media(max-width:991px){
            .login-left{
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row login-wrapper align-items-center">

        <div class="col-lg-7 login-left">
            <h1>Sistem Penerimaan Mahasiswa Baru</h1>

            <p>
                Platform PMB modern untuk pendaftaran online,
                upload dokumen, pengumuman hasil seleksi,
                hingga daftar ulang mahasiswa.
            </p>

            <div class="feature-box">
                <h5><i class="bi bi-check-circle-fill"></i> Pendaftaran Online</h5>
                <small>Isi biodata dan upload dokumen secara digital.</small>
            </div>

            <div class="feature-box">
                <h5><i class="bi bi-shield-check"></i> Verifikasi Aman</h5>
                <small>Dokumen diverifikasi langsung oleh admin kampus.</small>
            </div>

            <div class="feature-box">
                <h5><i class="bi bi-megaphone-fill"></i> Pengumuman Real-time</h5>
                <small>Lihat hasil seleksi secara langsung.</small>
            </div>
        </div>

        <div class="col-lg-5 d-flex justify-content-center align-items-center p-4">

            <div class="login-card w-100" style="max-width:500px;">

                <div class="text-center mb-4">
                    <h2>Login</h2>
                    <p class="text-muted">Masuk ke akun PMB Anda</p>
                </div>

                <?php if(isset($_GET['error'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        Email atau password salah!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Registrasi berhasil, silakan login.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="/pmb_universitas/mahasiswa/proses_login.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>

                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" required>

                            <span class="input-group-text" onclick="togglePassword()">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>

                </form>

                <div class="text-center mt-4">
                    <small>
                        Belum punya akun?
                        <a href="register.php" class="text-decoration-none fw-semibold">
                            Daftar Sekarang
                        </a>
                    </small>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if(password.type === 'password'){
        password.type = 'text';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>