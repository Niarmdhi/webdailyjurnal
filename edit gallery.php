<?php
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM gallery WHERE id_gallery=$id");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn, "UPDATE gallery SET 
        judul='$judul',
        deskripsi='$deskripsi'
        WHERE id_gallery=$id");

    header("Location: gallery.php");
}
?>

<form method="post">
    <h2>Edit Gallery</h2>
    Judul <br>
    <input type="text" name="judul" value="<?= $row['judul'] ?>"><br><br>

    Deskripsi <br>
    <textarea name="deskripsi"><?= $row['deskripsi'] ?></textarea><br><br>

    <button name="update">Update</button>
</form>
