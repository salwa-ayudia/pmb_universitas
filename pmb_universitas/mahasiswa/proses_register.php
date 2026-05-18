<?php
include '../config/koneksi.php';

$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
$email = htmlspecialchars($_POST['email']);
$no_hp = htmlspecialchars($_POST['no_hp']);
$password = md5($_POST['password']);

$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($cek) > 0){
    header("Location: register.php?error=1");
    exit;
}

$query = mysqli_query($conn, "INSERT INTO users(
    nama_lengkap,
    email,
    no_hp,
    password,
    role
) VALUES (
    '$nama_lengkap',
    '$email',
    '$no_hp',
    '$password',
    'mahasiswa'
)");

if($query){
    header("Location: login.php?success=1");
} else {
    echo "Registrasi gagal!";
}
?>