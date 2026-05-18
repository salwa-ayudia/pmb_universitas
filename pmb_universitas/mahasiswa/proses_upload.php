<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM pendaftaran 
WHERE id_user='$id_user'");

$data = mysqli_fetch_assoc($query);

$id_pendaftaran = $data['id_pendaftaran'];

function uploadFile($name, $folder){

    if($_FILES[$name]['name'] == ''){
        return null;
    }

    $filename = time() . '_' . $_FILES[$name]['name'];

    $tmp = $_FILES[$name]['tmp_name'];

    $path = "../uploads/$folder/" . $filename;

    move_uploaded_file($tmp, $path);

    return $filename;
}

$foto             = uploadFile('foto', 'foto');
$ktp              = uploadFile('ktp', 'ktp');
$kartu_keluarga   = uploadFile('kartu_keluarga', 'kk');
$ijazah           = uploadFile('ijazah', 'ijazah');
$raport           = uploadFile('raport', 'raport');
$sertifikat       = uploadFile('sertifikat', 'sertifikat');

$cek = mysqli_query($conn, "SELECT * FROM dokumen 
WHERE id_pendaftaran='$id_pendaftaran'");

if(mysqli_num_rows($cek) > 0){

    $update = [];

    if($foto) $update[] = "foto='$foto'";
    if($ktp) $update[] = "ktp='$ktp'";
    if($kartu_keluarga) $update[] = "kartu_keluarga='$kartu_keluarga'";
    if($ijazah) $update[] = "ijazah='$ijazah'";
    if($raport) $update[] = "raport='$raport'";
    if($sertifikat) $update[] = "sertifikat='$sertifikat'";

    if(!empty($update)){

        $sql = "UPDATE dokumen SET " . implode(',', $update) . "
                WHERE id_pendaftaran='$id_pendaftaran'";

        mysqli_query($conn, $sql);
    }

} else {

    mysqli_query($conn, "INSERT INTO dokumen(

        id_pendaftaran,
        foto,
        ktp,
        kartu_keluarga,
        ijazah,
        raport,
        sertifikat

    ) VALUES (

        '$id_pendaftaran',
        '$foto',
        '$ktp',
        '$kartu_keluarga',
        '$ijazah',
        '$raport',
        '$sertifikat'
    )");

}

header("Location: upload.php?success=1");
?>