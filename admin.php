<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// --- ARTICLE ---
$sql1 = "SELECT * FROM articel"; 
$hasil1 = $koneksi->query($sql1);

// cek error query
if (!$hasil1) {
    $jumlah_article = 0;
} else {
    $jumlah_article = $hasil1->num_rows;
}

// --- GALLERY ---
$sql2 = "SELECT * FROM gallery"; 
$hasil2 = $koneksi->query($sql2);

// cek error query
if (!$hasil2) {
    $jumlah_gallery = 0;
} else {
    $jumlah_gallery = $hasil2->num_rows;
}

// --- USER ---
$sql3 = "SELECT * FROM user"; 
$hasil3 = $koneksi->query($sql3);

// cek error query
if (!$hasil3) {
    $jumlah_user = 0;
} else {
    $jumlah_user = $hasil3->num_rows;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Harian Saya | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header-pink {
            background-color: #f8d7da;
            padding: 15px 0;
        }
        .dashboard-card {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            margin: 20px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .card-number {
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
        .card-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .navbar-custom {
            background-color: transparent;
        }
        .nav-link-custom {
            color: #333 !important;
            text-decoration: none;
            margin: 0 15px;
        }
        .nav-link-custom:hover {
            color: #007bff !important;
        }
        .admin-dropdown {
            color: #dc3545 !important;
            font-weight: bold;
        }
        .footer-pink {
            background-color: #f8d7da;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-pink">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Jurnal Harian Saya</h4>
                <nav class="navbar navbar-expand-lg navbar-custom">
                    <div class="navbar-nav">
                        <a class="nav-link nav-link-custom" href="admin.php">Dasbor</a>
                        <a class="nav-link nav-link-custom" href="article.php">Artikel</a>
                        <a class="nav-link nav-link-custom" href="user.php">User</a>
                        <a class="nav-link nav-link-custom" href="gallery.php">Gallery</a>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle admin-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <p class="text-muted">Selamat Datang <?php echo $_SESSION['username']; ?></p>
                <h2 class="mb-4">dasbor</h2>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="dashboard-card" onclick="location.href='article.php'">
                    <i class="bi bi-newspaper" style="font-size: 24px; color: #333;"></i>
                    <div class="card-title">Artikel</div>
                    <div class="card-number"><?php echo $jumlah_article; ?></div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="dashboard-card" onclick="location.href='gallery.php'">
                    <i class="bi bi-images" style="font-size: 24px; color: #333;"></i>
                    <div class="card-title">Gallery</div>
                    <div class="card-number"><?php echo $jumlah_gallery; ?></div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="dashboard-card" onclick="location.href='user.php'">
                    <i class="bi bi-people" style="font-size: 24px; color: #333;"></i>
                    <div class="card-title">User</div>
                    <div class="card-number"><?php echo $jumlah_user; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-pink">
        <div class="container text-center">
            <div class="d-flex justify-content-center align-items-center">
                <a href="#" class="text-dark me-3"><i class="bi bi-instagram" style="font-size: 24px;"></i></a>
                <a href="#" class="text-dark me-3"><i class="bi bi-twitter" style="font-size: 24px;"></i></a>
                <a href="#" class="text-dark"><i class="bi bi-whatsapp" style="font-size: 24px;"></i></a>
            </div>
            <p class="mt-2 mb-0 small text-muted">NIA RAMADHANI © 2025</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>