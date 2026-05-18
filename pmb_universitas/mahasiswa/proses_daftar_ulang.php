<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// ambil id user login
$id_user = $_SESSION['id_user'];

// ambil data pendaftaran user
$query = mysqli_query($conn, "
SELECT * FROM pendaftaran
WHERE id_user = '$id_user'
");

$pendaftaran = mysqli_fetch_assoc($query);

if (!$pendaftaran) {
    echo "
    <script>
        alert('Data pendaftaran tidak ditemukan!');
        window.location='pengumuman.php';
    </script>
    ";
    exit;
}

$id_pendaftaran = $pendaftaran['id_pendaftaran'];


// =========================
// VALIDASI FILE
// =========================

if (!isset($_FILES['bukti_pembayaran'])) {

    echo "
    <script>
        alert('File bukti pembayaran belum dipilih!');
        window.location='daftar_ulang.php';
    </script>
    ";
    exit;
}

$nama_file = $_FILES['bukti_pembayaran']['name'];
$tmp_file  = $_FILES['bukti_pembayaran']['tmp_name'];
$ukuran    = $_FILES['bukti_pembayaran']['size'];

$ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

$allowed = ['jpg', 'jpeg', 'png', 'pdf'];

if (!in_array($ext, $allowed)) {

    echo "
    <script>
        alert('Format file tidak didukung!');
        window.location='daftar_ulang.php';
    </script>
    ";
    exit;
}

if ($ukuran > 2000000) {

    echo "
    <script>
        alert('Ukuran file maksimal 2MB!');
        window.location='daftar_ulang.php';
    </script>
    ";
    exit;
}


// =========================
// UPLOAD FILE
// =========================

$folder = "../assets/bukti_pembayaran/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$nama_baru = "bukti_" . time() . "." . $ext;

move_uploaded_file($tmp_file, $folder . $nama_baru);


// =========================
// SIMPAN DATABASE
// =========================

$tanggal_bayar = date('Y-m-d');

$nominal = 2500000;

$cek = mysqli_query($conn, "
SELECT * FROM daftar_ulang
WHERE id_pendaftaran = '$id_pendaftaran'
");

if (mysqli_num_rows($cek) > 0) {

    mysqli_query($conn, "
    UPDATE daftar_ulang SET
        bukti_pembayaran = '$nama_baru',
        tanggal_bayar = '$tanggal_bayar',
        nominal = '$nominal',
        status_verifikasi = 'menunggu'
    WHERE id_pendaftaran = '$id_pendaftaran'
    ");

} else {

    mysqli_query($conn, "
    INSERT INTO daftar_ulang (
        id_pendaftaran,
        bukti_pembayaran,
        tanggal_bayar,
        nominal,
        status_verifikasi
    ) VALUES (
        '$id_pendaftaran',
        '$nama_baru',
        '$tanggal_bayar',
        '$nominal',
        'menunggu'
    )
    ");

}


// =========================
// REDIRECT
// =========================

echo "
<script>
    alert('Bukti pembayaran berhasil dikirim!');
    window.location='pengumuman.php';
</script>
";
?>