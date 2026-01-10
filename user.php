<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";
include "upload_foto.php";

// ====================== INSERT / UPDATE ======================
if (isset($_POST['simpan'])) {

    $username = $_POST['username'];
    $password = isset($_POST['password']) ? md5($_POST['password']) : '';
    $foto = "default.jpg";
    $nama_foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";

    // Cek apakah username sudah ada (untuk insert baru)
    if (!isset($_POST['id'])) {
        $check_username = "SELECT username FROM user WHERE username = ?";
        $stmt_check = $koneksi->prepare($check_username);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            echo "<script>alert('Username sudah digunakan!'); </script>";
            exit;
        }
    }

    // Upload foto baru jika ada
    if ($nama_foto != "") {
        $upload = upload_foto($_FILES['foto']);
        if ($upload['status']) {
            $foto = $upload['message'];
        } else {
            echo "<script>alert('" . $upload['message'] . "');</script>";
            exit;
        }
    }

    // ========== UPDATE DATA ==========
    if (isset($_POST['id'])) {

        $id = $_POST['id'];

        if ($nama_foto == "") {
            $foto = $_POST['foto_lama'];
        } else {
            if (file_exists("img/" . $_POST['foto_lama']) && $_POST['foto_lama'] != 'default.jpg')
                unlink("img/" . $_POST['foto_lama']);
        }

        if ($password != '') {
            // Update dengan password baru
            $stmt = $koneksi->prepare("UPDATE user SET username=?, password=?, foto=? WHERE id_user=?");
            $stmt->bind_param("sssi", $username, $password, $foto, $id);
        } else {
            // Update tanpa mengubah password
            $stmt = $koneksi->prepare("UPDATE user SET username=?, foto=? WHERE id_user=?");
            $stmt->bind_param("ssi", $username, $foto, $id);
        }
        $simpan = $stmt->execute();

    } else {
        // ========== INSERT BARU ==========
        $stmt = $koneksi->prepare("INSERT INTO user (username, password, foto) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $password, $foto);
        $simpan = $stmt->execute();
    }

    echo "<script>alert('Data berhasil disimpan'); document.location='admin_main.php?page=user';</script>";
    exit;
}


// ====================== HAPUS DATA ======================
if (isset($_POST['hapus'])) {

    $id = $_POST['id'];
    $foto = $_POST['foto'];

    // Cek apakah user yang akan dihapus adalah user yang sedang login
    if ($_POST['username'] == $_SESSION['username']) {
        echo "<script>alert('Tidak dapat menghapus akun sendiri!'); </script>";
        exit;
    }

    if ($foto != "" && $foto != "default.jpg" && file_exists("img/" . $foto)) {
        unlink("img/" . $foto);
    }

    $stmt = $koneksi->prepare("DELETE FROM user WHERE id_user=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    echo "<script>alert('Data berhasil dihapus'); document.location='admin_main.php?page=user';</script>";
    exit;
}
?>

<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
    <div class="row">
    <div class="table-responsive" id="user_data">

    </div>
    
        <!-- MODAL TAMBAH -->
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5>Tambah User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label>Foto Profile</label>
                                <input type="file" class="form-control" name="foto">
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
            url : "user_data.php",
            method : "POST",
            data : {
					            hlm: hlm
				           },
            success : function(data){
                    $('#user_data').html(data);
            }
        })
    }
    $(document).on('click', '.halaman', function(){
    var hlm = $(this).attr("id");
    load_data(hlm);
}); 
});
</script>