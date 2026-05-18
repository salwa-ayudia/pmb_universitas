<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM pendaftaran 
WHERE id_user='$id_user'");

$data = mysqli_fetch_assoc($query);

$id_pendaftaran = $data['id_pendaftaran'];

$queryDokumen = mysqli_query($conn, "SELECT * FROM dokumen 
WHERE id_pendaftaran='$id_pendaftaran'");

$dokumen = mysqli_fetch_assoc($queryDokumen);

if(
    empty($dokumen['foto']) ||
    empty($dokumen['ktp']) ||
    empty($dokumen['kartu_keluarga']) ||
    empty($dokumen['ijazah']) ||
    empty($dokumen['raport'])
){
    header("Location: submit_pendaftaran.php");
    exit;
}

mysqli_query($conn, "UPDATE pendaftaran SET
status_pendaftaran='submitted'
WHERE id_pendaftaran='$id_pendaftaran'");

header("Location: submit_pendaftaran.php?success=1");
?>