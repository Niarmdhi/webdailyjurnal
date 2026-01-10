<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";
include "upload_foto.php";

// ====================== INSERT / UPDATE ======================
if (isset($_POST['simpan'])) {

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_upload = date("Y-m-d H:i:s");
    $gambar = "";
    $nama_gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : "";

    // Upload gambar baru jika ada
    if ($nama_gambar != "") {
        $upload = upload_foto($_FILES['gambar']);
        if ($upload['status']) {
            $gambar = $upload['message'];
        } else {
            echo "<script>alert('" . $upload['message'] . "');</script>";
            exit;
        }
    }

    // ========== UPDATE DATA ==========
    if (isset($_POST['id'])) {

        $id = $_POST['id'];

        if ($nama_gambar == "") {
            $gambar = $_POST['gambar_lama'];
        } else {
            if (file_exists("img/" . $_POST['gambar_lama']))
                unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $koneksi->prepare("UPDATE gallery SET judul=?, deskripsi=?, gambar=?, tanggal_upload=? WHERE id_gallery=?");
        $stmt->bind_param("ssssi", $judul, $deskripsi, $gambar, $tanggal_upload, $id);
        $simpan = $stmt->execute();

    } else {
        // ========== INSERT BARU ==========
        $stmt = $koneksi->prepare("INSERT INTO gallery (judul, deskripsi, gambar, tanggal_upload) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $judul, $deskripsi, $gambar, $tanggal_upload);
        $simpan = $stmt->execute();
    }

    echo "<script>alert('Data berhasil disimpan'); document.location='admin_main.php?page=gallery';</script>";
    exit;
}


// ====================== HAPUS DATA ======================
if (isset($_POST['hapus'])) {

    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != "" && file_exists("img/" . $gambar)) {
        unlink("img/" . $gambar);
    }

    $stmt = $koneksi->prepare("DELETE FROM gallery WHERE id_gallery=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    echo "<script>alert('Data berhasil dihapus'); document.location='admin_main.php?page=gallery';</script>";
    exit;
}
?>

<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gallery
    </button>
    <div class="row">
    <div class="table-responsive" id="gallery_data">

    </div>
    
        <!-- MODAL TAMBAH -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5>Tambah Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>

                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Gambar</label>
                                <input type="file" class="form-control" name="gambar" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function(){
    load_data();
    function load_data(hlm){
        $.ajax({
            url : "gallery_data.php",
            method : "POST",
            data : {
					            hlm: hlm
				           },
            success : function(data){
                    $('#gallery_data').html(data);
            }
        })
    }
    $(document).on('click', '.halaman', function(){
    var hlm = $(this).attr("id");
    load_data(hlm);
}); 
});
</script>