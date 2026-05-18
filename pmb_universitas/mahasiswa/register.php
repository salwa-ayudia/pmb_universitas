<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register PMB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: linear-gradient(135deg, #0d6efd, #001f54);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .register-card{
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 15px 40px rgba(0,0,0,.15);
        }

        .register-card h2{
            font-weight: 700;
            color: #001f54;
        }

        .form-control{
            height: 55px;
            border-radius: 14px;
        }

        .btn-register{
            height: 55px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0d6efd, #001f54);
            border: none;
            font-weight: 600;
        }

        .input-group-text{
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="text-center mb-4">
        <h2>Registrasi Akun PMB</h2>
        <p class="text-muted">
            Buat akun untuk memulai pendaftaran mahasiswa baru
        </p>
    </div>

    <?php if(isset($_GET['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show">
            Email sudah digunakan!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="proses_register.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" class="form-control" required>
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

        <button type="submit" class="btn btn-primary btn-register w-100">
            <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
        </button>

    </form>

    <div class="text-center mt-4">
        <small>
            Sudah punya akun?
            <a href="login.php" class="text-decoration-none fw-semibold">
                Login
            </a>
        </small>
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