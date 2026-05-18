<?php
session_start();

/* HAPUS SEMUA SESSION */
session_unset();
session_destroy();

/* REDIRECT KE LOGIN ADMIN */
header("Location: login.php");
exit;
?>