<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../img/" . $gambar);

    mysqli_query($koneksi, "INSERT INTO gallery 
        (judul, deskripsi, gambar)
        VALUES ('$judul', '$deskripsi', '$gambar')");

    header("Location: gallery.php");
}
?>

<form method="post" enctype="multipart/form-data">
    <h2>Tambah Gallery</h2>
    Judul <br>
    <input type="text" name="judul" required><br><br>

    Deskripsi <br>
    <textarea name="deskripsi" required></textarea><br><br>

    Gambar <br>
    <input type="file" name="gambar" required><br><br>

    <button name="simpan">Simpan</button>
</form>
