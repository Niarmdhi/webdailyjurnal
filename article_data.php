<table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Judul</th>
                        <th class="w-75">Isi</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("koneksi.php");
                    $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
                    $limit = 3;
                    $limit_start = ($hlm - 1) * $limit;
                    $no = $limit_start + 1;

                    $sql = "SELECT * FROM articel ORDER BY tanggal DESC LIMIT $limit_start, $limit";
                    $hasil = $koneksi->query($sql); // Perbaikan 1: pakai $koneksi

                    while ($row = $hasil->fetch_assoc()) { // Perbaikan 2: pakai $hasil->fetch_assoc()
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <strong><?= $row["judul"] ?></strong><br>
                                pada : <?= $row["tanggal"] ?><br>
                                oleh : <?= $row["username"] ?>
                            </td>

                            <td><?= nl2br($row["isi"]) ?></td>

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
                                   data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                                   <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <a href="#" class="badge rounded-pill text-bg-danger"
                                   data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                                   <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="modalEdit<?= $row["id"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5>Edit Article</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">

                                            <div class="mb-3">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="judul"
                                                       value="<?= $row["judul"] ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Isi</label>
                                                <textarea class="form-control" name="isi" required><?= $row["isi"] ?></textarea>
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
                        <div class="modal fade" id="modalHapus<?= $row["id"] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form method="post">
                                        <div class="modal-header">
                                            <h5>Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Yakin hapus "<b><?= $row["judul"] ?></b>" ?
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
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
$sql1 = "SELECT * FROM articel";
$hasil1 = $koneksi->query($sql1);
$total_records = $hasil1->num_rows;
?>

<p>Total article : <?= $total_records ?></p>

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
