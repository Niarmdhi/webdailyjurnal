<?php
// Handler untuk form submit dari user_data.php (yang di-load via AJAX)
if ((isset($_POST['simpan']) || isset($_POST['hapus'])) && !isset($_POST['hlm'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include("koneksi.php");
    include("upload_foto.php");
    
    // Proses simpan
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
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows > 0) {
                echo "<script>alert('Username sudah digunakan!'); window.location.href='admin_main.php?page=user_data';</script>";
                exit;
            }
        }

        // Upload foto baru jika ada
        if ($nama_foto != "") {
            $upload = upload_foto($_FILES['foto']);
            if ($upload['status']) {
                $foto = $upload['message'];
            } else {
                echo "<script>alert('" . $upload['message'] . "'); window.location.href='admin_main.php?page=user_data';</script>";
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
                $stmt = $koneksi->prepare("UPDATE user SET username=?, password=?, foto=? WHERE id_user=?");
                $stmt->bind_param("sssi", $username, $password, $foto, $id);
            } else {
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

        if ($simpan) {
            echo "<script>alert('Data berhasil disimpan'); window.location.href='admin_main.php?page=user_data';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='admin_main.php?page=user_data';</script>";
            exit;
        }
    }
    
    // Proses hapus
    if (isset($_POST['hapus'])) {
        $id = $_POST['id'];
        $foto = $_POST['foto'];

        // Cek apakah user yang akan dihapus adalah user yang sedang login
        if ($_POST['username'] == $_SESSION['username']) {
            echo "<script>alert('Tidak dapat menghapus akun sendiri!'); window.location.href='admin_main.php?page=user_data';</script>";
            exit;
        }

        if ($foto != "" && $foto != "default.jpg" && file_exists("img/" . $foto)) {
            unlink("img/" . $foto);
        }

        $stmt = $koneksi->prepare("DELETE FROM user WHERE id_user=?");
        $stmt->bind_param("i", $id);
        $hapus = $stmt->execute();

        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location.href='admin_main.php?page=user_data';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='admin_main.php?page=user_data';</script>";
            exit;
        }
    }
}
?>

<button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah User
</button>

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

<table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Username</th>
                        <th class="w-25">Foto Profile</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    include("koneksi.php");
                    // Support both POST (AJAX) and GET (direct access) for pagination
                    $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : ((isset($_GET['hlm'])) ? $_GET['hlm'] : 1);
                    $limit = 4;
                    $limit_start = ($hlm - 1) * $limit;
                    $no = $limit_start + 1;

                    $sql = "SELECT * FROM user ORDER BY id_user DESC LIMIT $limit_start, $limit";
                    $hasil = $koneksi->query($sql);

                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <strong><?= $row["username"] ?></strong>
                            </td>

                            <td>
                                <?php if (isset($row["foto"]) && $row["foto"] != "" && file_exists("img/" . $row["foto"])) { ?>
                                    <!-- <img src="img/<?= $row["foto"] ?>" width="80" style="border-radius: 50%;"> -->
                                     <img src="img/default.jpg" width="80" style="border-radius: 50%;">
                                <?php } else { ?>
                                    <img src="img/default.jpg" width="80" style="border-radius: 50%;">
                                <?php } ?>
                            </td>

                            <td>
                                <!-- Tombol Edit -->
                                <a href="#" class="badge rounded-pill text-bg-success"
                                   data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id_user"] ?>">
                                   <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Tombol Hapus (tidak bisa hapus diri sendiri) -->
                                <?php if (!isset($_SESSION['username']) || $row["username"] != $_SESSION['username']) { ?>
                                <a href="#" class="badge rounded-pill text-bg-danger"
                                   data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id_user"] ?>">
                                   <i class="bi bi-x-circle"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="modalEdit<?= $row["id_user"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5>Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <input type="hidden" name="id" value="<?= $row["id_user"] ?>">

                                            <div class="mb-3">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username"
                                                       value="<?= $row["username"] ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>

                                            <div class="mb-3">
                                                <label>Ganti Foto Profile</label>
                                                <input type="file" class="form-control" name="foto">
                                            </div>

                                            <div class="mb-3">
                                                <label>Foto Profile Lama</label><br>
                                                <?php if (isset($row["foto"]) && $row["foto"] && file_exists("img/" . $row["foto"])) { ?>
                                                    <img src="img/<?= $row["foto"] ?>" width="100" style="border-radius: 50%;">
                                                <?php } else { ?>
                                                    <img src="img/default.jpg" width="100" style="border-radius: 50%;">
                                                <?php } ?>
                                                <input type="hidden" name="foto_lama" value="<?= isset($row["foto"]) ? $row["foto"] : '' ?>">
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

                        <!-- MODAL HAPUS -->
                        <?php if (!isset($_SESSION['username']) || $row["username"] != $_SESSION['username']) { ?>
                        <div class="modal fade" id="modalHapus<?= $row["id_user"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post">
                                        <div class="modal-header">
                                            <h5>Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Yakin hapus user "<b><?= $row["username"] ?></b>" ?
                                            <input type="hidden" name="id" value="<?= $row["id_user"] ?>">
                                            <input type="hidden" name="username" value="<?= $row["username"] ?>">
                                            <input type="hidden" name="foto" value="<?= $row["foto"] ?>">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php 
                } 
                ?>
                </tbody>
            </table>

<?php
$sql1 = "SELECT * FROM user";
$hasil1 = $koneksi->query($sql1);
$total_records = $hasil1->num_rows;
?>

<p>Total user : <?= $total_records ?></p>

<nav class="mb-2">
<ul class="pagination justify-content-end">
<?php
$jumlah_page = ceil($total_records / $limit);

if ($hlm > 1) {
    echo '<li class="page-item halaman" id="'.($hlm-1).'"><a class="page-link">&laquo;</a></li>';
}

for ($i=1; $i<=$jumlah_page; $i++) {
    $active = ($i == $hlm) ? 'active' : '';
    echo '<li class="page-item halaman '.$active.'" id="'.$i.'">
            <a class="page-link">'.$i.'</a>
          </li>';
}

if ($hlm < $jumlah_page) {
    echo '<li class="page-item halaman" id="'.($hlm+1).'"><a class="page-link">&raquo;</a></li>';
}
?>
</ul>
</nav>

<script>
// Support pagination when accessed directly (not via AJAX from user.php)
// Check if we're in user_data.php directly (not loaded via AJAX)
if (window.location.href.indexOf('user_data') > -1 || window.location.href.indexOf('page=user_data') > -1) {
    $(document).ready(function(){
        $(document).on('click', '.halaman', function(e){
            e.preventDefault();
            var hlm = $(this).attr("id");
            window.location.href = 'admin_main.php?page=user_data&hlm=' + hlm;
        });
    });
}
</script>