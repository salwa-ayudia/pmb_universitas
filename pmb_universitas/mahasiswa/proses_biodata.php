<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$nik                = htmlspecialchars($_POST['nik']);
$nisn               = htmlspecialchars($_POST['nisn']);
$tempat_lahir       = htmlspecialchars($_POST['tempat_lahir']);
$tanggal_lahir      = $_POST['tanggal_lahir'];
$jenis_kelamin      = $_POST['jenis_kelamin'];
$alamat             = htmlspecialchars($_POST['alamat']);
$agama              = $_POST['agama'];
$asal_sekolah       = htmlspecialchars($_POST['asal_sekolah']);
$tahun_lulus        = $_POST['tahun_lulus'];
$nama_ayah          = htmlspecialchars($_POST['nama_ayah']);
$nama_ibu           = htmlspecialchars($_POST['nama_ibu']);
$no_hp_ortu         = htmlspecialchars($_POST['no_hp_ortu']);
$jurusan_pilihan    = $_POST['jurusan_pilihan'];

$cek = mysqli_query($conn, "SELECT * FROM pendaftaran 
WHERE id_user='$id_user'");

if(mysqli_num_rows($cek) > 0){

    mysqli_query($conn, "UPDATE pendaftaran SET

        nik='$nik',
        nisn='$nisn',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir='$tanggal_lahir',
        jenis_kelamin='$jenis_kelamin',
        alamat='$alamat',
        agama='$agama',
        asal_sekolah='$asal_sekolah',
        tahun_lulus='$tahun_lulus',
        nama_ayah='$nama_ayah',
        nama_ibu='$nama_ibu',
        no_hp_ortu='$no_hp_ortu',
        jurusan_pilihan='$jurusan_pilihan'

        WHERE id_user='$id_user'
    ");

} else {

    $nomor_pendaftaran = "PMB" . date('Ymd') . rand(100,999);

    mysqli_query($conn, "INSERT INTO pendaftaran(

        id_user,
        nomor_pendaftaran,
        nik,
        nisn,
        tempat_lahir,
        tanggal_lahir,
        jenis_kelamin,
        alamat,
        agama,
        asal_sekolah,
        tahun_lulus,
        nama_ayah,
        nama_ibu,
        no_hp_ortu,
        jurusan_pilihan,
        status_pendaftaran

    ) VALUES (

        '$id_user',
        '$nomor_pendaftaran',
        '$nik',
        '$nisn',
        '$tempat_lahir',
        '$tanggal_lahir',
        '$jenis_kelamin',
        '$alamat',
        '$agama',
        '$asal_sekolah',
        '$tahun_lulus',
        '$nama_ayah',
        '$nama_ibu',
        '$no_hp_ortu',
        '$jurusan_pilihan',
        'draft'
    )");

}

header("Location: biodata.php?success=1");
?>  