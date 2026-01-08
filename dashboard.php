<?php
// include koneksi
include "koneksi.php";

// --- ARTICLE ---
$sql1 = "SELECT * FROM articel"; 
$hasil1 = $koneksi->query($sql1);

// cek error query
if (!$hasil1) {
    die("Query error (articel): " . $koneksi->error);
}

$jumlah_article = $hasil1->num_rows;
?>

<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
    <div class="col">
        <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2">
                            <?php echo $jumlah_article; ?>
                        </span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div>
