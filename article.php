<?php
include "koneksi.php";
include "upload_foto.php";
?>

<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Article
    </button>
    <div class="row">
    <div class="table-responsive" id="article_data">

    </div>
    
        <!-- MODAL TAMBAH -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5>Tambah Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>

                            <div class="mb-3">
                                <label>Isi</label>
                                <textarea class="form-control" name="isi" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Gambar</label>
                                <input type="file" class="form-control" name="gambar">
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
            url : "article_data.php",
            method : "POST",
            data : {
					            hlm: hlm
				           },
            success : function(data){
                    $('#article_data').html(data);
            }
        })
    }
    $(document).on('click', '.halaman', function(){
    var hlm = $(this).attr("id");
    load_data(hlm);
}); 
});
</script>

<?php
// ====================== INSERT / UPDATE ======================
if (isset($_POST['simpan'])) {

    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = "";
    $nama_gambar = $_FILES['gambar']['name'];

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

        $stmt = $koneksi->prepare("UPDATE articel SET judul=?, isi=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();

    } else {
        // ========== INSERT BARU ==========
        $stmt = $koneksi->prepare("INSERT INTO articel (judul, isi, gambar, tanggal, username) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    echo "<script>alert('Data berhasil disimpan'); document.location='admin.php?page=article';</script>";
}


// ====================== HAPUS DATA ======================
if (isset($_POST['hapus'])) {

    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != "" && file_exists("img/" . $gambar)) {
        unlink("img/" . $gambar);
    }

    $stmt = $koneksi->prepare("DELETE FROM articel WHERE id=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    echo "<script>alert('Data berhasil dihapus'); document.location='admin.php?page=article';</script>";
}

?>
