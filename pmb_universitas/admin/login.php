<?php
session_start();

$captcha1 = rand(1,9);
$captcha2 = rand(1,9);

$_SESSION['captcha_admin'] = $captcha1 + $captcha2;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin PMB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            min-height: 100vh;
            background:
            linear-gradient(rgba(0,31,84,.85), rgba(13,110,253,.85)),
            url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            overflow-x: hidden;
        }

        .login-wrapper{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-card{
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(10px);
            border-radius: 35px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,.25);
            width: 100%;
            max-width: 1150px;
        }

        .left-side{
            background: linear-gradient(135deg,#001f54,#0d6efd);
            color: white;
            padding: 60px;
            height: 100%;
            position: relative;
        }

        .left-side::before{
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }

        .left-side::after{
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
            bottom: -60px;
            left: -60px;
        }

        .brand{
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }

        .hero-title{
            font-size: 42px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .hero-text{
            opacity: .9;
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        .hero-image{
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }

        .right-side{
            padding: 60px 50px;
        }

        .login-title{
            font-size: 34px;
            font-weight: 700;
            color: #001f54;
            margin-bottom: 10px;
        }

        .login-subtitle{
            color: #777;
            margin-bottom: 40px;
        }

        .form-label{
            font-weight: 600;
            margin-bottom: 10px;
        }

        .input-group{
            margin-bottom: 22px;
        }

        .input-group-text{
            border-radius: 15px 0 0 15px;
            border-right: none;
            background: #f8f9fa;
            padding: 0 18px;
        }

        .form-control{
            height: 58px;
            border-radius: 0 15px 15px 0;
            border-left: none;
            font-size: 15px;
        }

        .form-control:focus{
            box-shadow: none;
            border-color: #ced4da;
        }

        .captcha-box{
            background: linear-gradient(135deg,#0d6efd,#001f54);
            color: white;
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .btn-login{
            height: 58px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg,#0d6efd,#001f54);
            font-weight: 600;
            font-size: 16px;
            transition: .3s;
        }

        .btn-login:hover{
            transform: translateY(-2px);
        }

        .back-link{
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover{
            color: #001f54;
        }

        .alert{
            border-radius: 15px;
        }

        @media(max-width: 991px){

            .left-side{
                display: none;
            }

            .right-side{
                padding: 40px 25px;
            }

        }

    </style>

</head>
<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="row g-0">

            <!-- LEFT -->

            <div class="col-lg-6">

                <div class="left-side">

                    <div class="brand">
                        <i class="bi bi-mortarboard-fill"></i>
                        PMB Kampus
                    </div>

                    <h1 class="hero-title">
                        Dashboard
                        Administrator PMB
                    </h1>

                    <p class="hero-text">
                        Kelola seluruh proses penerimaan mahasiswa baru
                        secara digital, cepat, aman, dan terintegrasi.
                    </p>

                    <div class="hero-image text-center">

                        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png"
                             width="320"
                             class="img-fluid">

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-6">

                <div class="right-side">

                    <h2 class="login-title">
                        Login Admin
                    </h2>

                    <p class="login-subtitle">
                        Masuk untuk mengelola sistem PMB kampus.
                    </p>

                    <?php if(isset($_GET['error'])) : ?>

                        <div class="alert alert-danger alert-dismissible fade show">

                            Email atau password salah.

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">

                            </button>

                        </div>

                    <?php endif; ?>

                    <?php if(isset($_GET['captcha'])) : ?>

                        <div class="alert alert-warning alert-dismissible fade show">

                            Jawaban captcha salah.

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">

                            </button>

                        </div>

                    <?php endif; ?>

                    <form action="proses_login.php" method="POST">

                        <label class="form-label">
                            Email Admin
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Masukkan email admin"
                                   required>

                        </div>

                        <label class="form-label">
                            Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Masukkan password"
                                   required>

                        </div>

                        <label class="form-label">
                            Verifikasi Captcha
                        </label>

                        <div class="captcha-box">

                            <?php echo $captcha1; ?>
                            +
                            <?php echo $captcha2; ?>
                            = ?

                        </div>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-shield-lock-fill"></i>
                            </span>

                            <input type="number"
                                   name="captcha"
                                   class="form-control"
                                   placeholder="Masukkan hasil captcha"
                                   required>

                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-login w-100 mt-3">

                            <i class="bi bi-box-arrow-in-right"></i>
                            Login Sekarang

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>