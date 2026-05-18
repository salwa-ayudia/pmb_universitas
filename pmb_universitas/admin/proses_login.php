<?php
session_start();
include '../config/koneksi.php';

/* =========================
   CAPTCHA
========================= */

if($_POST['captcha'] != $_SESSION['captcha_admin']){
    header("Location: login.php?captcha=1");
    exit;
}

/* =========================
   AMBIL DATA
========================= */

$email = htmlspecialchars($_POST['email']);
$password = md5($_POST['password']);

/* =========================
   LOGIN ADMIN
========================= */

$query = mysqli_query($conn, "
SELECT * FROM users
WHERE email='$email'
AND password='$password'
AND role='admin'
");

$data = mysqli_fetch_assoc($query);

if(mysqli_num_rows($query) > 0){

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['role'] = $data['role'];

    header("Location: /pmb_universitas/admin/dashboard.php");
    exit;

}else{

    header("Location: login.php?error=1");
    exit;

}
?>