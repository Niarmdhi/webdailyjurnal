<?php
// Aktifkan error untuk debug (boleh dihapus jika sudah beres)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// KONFIGURASI DATABASE UNTUK HOSTING
// Sesuai catatan di bawah ini:
// Hostname: localhost
// Database: brabsenm_webdailyjurnal
// Username: brabsenm_webdailyjurnal
// Password: H5mhqtV5T5MS97AnsL6g

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "webdailyjurnal";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}