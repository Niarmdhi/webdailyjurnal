<?php
// Handler untuk form submit dari gallery_data.php (yang di-load via AJAX)
if ((isset($_POST['simpan']) || isset($_POST['hapus'])) && !isset($_POST['hlm'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include("koneksi.php");
    include("upload_foto.php");
    
    // Proses simpan
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
                echo "<script>alert('" . $upload['message'] . "'); window.location.href='admin_main.php?page=gallery_data';</script>";
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

        if ($simpan) {
            echo "<script>alert('Data berhasil disimpan'); window.location.href='admin_main.php?page=gallery_data';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='admin_main.php?page=gallery_data';</script>";
            exit;
        }
    }
    
    // Proses hapus
    if (isset($_POST['hapus'])) {
        $id = $_POST['id'];
        $gambar = $_POST['gambar'];

        if ($gambar != "" && file_exists("img/" . $gambar)) {
            unlink("img/" . $gambar);
        }

        $stmt = $koneksi->prepare("DELETE FROM gallery WHERE id_gallery=?");
        $stmt->bind_param("i", $id);
        $hapus = $stmt->execute();

        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location.href='admin_main.php?page=gallery_data';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='admin_main.php?page=gallery_data';</script>";
            exit;
        }
    }
}
?>

<button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah Gallery
</button>

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

<table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Judul</th>
                        <th class="w-50">Deskripsi</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("koneksi.php");
                    // Support both POST (AJAX) and GET (direct access) for pagination
                    $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : ((isset($_GET['hlm'])) ? $_GET['hlm'] : 1);
                    $limit = 4;
                    $limit_start = ($hlm - 1) * $limit;
                    $no = $limit_start + 1;

                    $sql = "SELECT * FROM gallery ORDER BY tanggal_upload DESC LIMIT $limit_start, $limit";
                    $hasil = $koneksi->query($sql);

                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <strong><?= $row["judul"] ?></strong><br>
                                pada : <?= $row["tanggal_upload"] ?>
                            </td>

                            <td><?= nl2br($row["deskripsi"]) ?></td>

                            <td>
                                <?php if ($row["gambar"] != "" && file_exists("img/" . $row["gambar"])) { ?>
                                    <img src="img/<?= $row["gambar"] ?>" width="120">
                                <?php } else { ?>
                                    <i>Tidak ada gambar</i>
                                <?php } ?>
                            </td>

                            <td>
                                <!-- Tombol Edit -->
                                <a href="#" class="badge rounded-pill text-bg-success"
                                   data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id_gallery"] ?>">
                                   <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <a href="#" class="badge rounded-pill text-bg-danger"
                                   data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id_gallery"] ?>">
                                   <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="modalEdit<?= $row["id_gallery"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5>Edit Gallery</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <input type="hidden" name="id" value="<?= $row["id_gallery"] ?>">

                                            <div class="mb-3">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="judul"
                                                       value="<?= $row["judul"] ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" required><?= $row["deskripsi"] ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label>Ganti Gambar</label>
                                                <input type="file" class="form-control" name="gambar">
                                            </div>

                                            <div class="mb-3">
                                                <label>Gambar Lama</label><br>
                                                <?php if ($row["gambar"] && file_exists("img/" . $row["gambar"])) { ?>
                                                    <img src="img/<?= $row["gambar"] ?>" width="100">
                                                <?php } ?>
                                                <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
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
                        <div class="modal fade" id="modalHapus<?= $row["id_gallery"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post">
                                        <div class="modal-header">
                                            <h5>Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Yakin hapus "<b><?= $row["judul"] ?></b>" ?
                                            <input type="hidden" name="id" value="<?= $row["id_gallery"] ?>">
                                            <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php 
                } 
                ?>
                </tbody>
            </table>

<?php
$sql1 = "SELECT * FROM gallery";
$hasil1 = $koneksi->query($sql1);
$total_records = $hasil1->num_rows;
?>

<p>Total gallery : <?= $total_records ?></p>

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
// Support pagination when accessed directly (not via AJAX from gallery.php)
if (window.location.href.indexOf('gallery_data') > -1 || window.location.href.indexOf('page=gallery_data') > -1) {
    $(document).ready(function(){
        $(document).on('click', '.halaman', function(e){
            e.preventDefault();
            var hlm = $(this).attr("id");
            window.location.href = 'admin_main.php?page=gallery_data&hlm=' + hlm;
        });
    });
}
</script>