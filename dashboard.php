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

// --- GALLERY ---
$sql2 = "SELECT * FROM gallery"; 
$hasil2 = $koneksi->query($sql2);

// cek error query
if (!$hasil2) {
    die("Query error (gallery): " . $koneksi->error);
}

$jumlah_gallery = $hasil2->num_rows;

// --- USER ---
$sql3 = "SELECT * FROM user"; 
$hasil3 = $koneksi->query($sql3);

// cek error query
if (!$hasil3) {
    die("Query error (user): " . $koneksi->error);
}

$jumlah_user = $hasil3->num_rows;
?>

<div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center pt-4">
    <!-- Card Article -->
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
    
    <!-- Card Gallery -->
    <div class="col">
        <div class="card border border-success mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-images"></i> Gallery</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-success fs-2">
                            <?php echo $jumlah_gallery; ?>
                        </span>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card User -->
    <div class="col">
        <div class="card border border-primary mb-3 shadow" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-people"></i> User</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-primary fs-2">
                            <?php echo $jumlah_user; ?>
                        </span>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
