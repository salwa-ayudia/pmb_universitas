<?php
session_start();
include '../config/koneksi.php';

/* =========================
   AMBIL DATA FORM
========================= */

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = md5($_POST['password']);

/* =========================
   QUERY LOGIN MAHASISWA
========================= */

$query = mysqli_query($conn, "
SELECT * FROM users
WHERE email='$email'
AND password='$password'
AND role='mahasiswa'
");

$data = mysqli_fetch_assoc($query);

/* =========================
   VALIDASI LOGIN
========================= */

if(mysqli_num_rows($query) > 0){

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['role'] = $data['role'];

    /* redirect mahasiswa */

    header("Location: /pmb_universitas/mahasiswa/dashboard.php");
    exit;

}else{

    header("Location: login.php?error=1");
    exit;

}
?>