<?php
$koneksi = mysqli_connect("localhost", "root", "", "webdailyjurnal");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
