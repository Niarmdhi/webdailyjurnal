<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>ARTICEL NIAAA</title>

  <link rel="icon" href="journal.svg" />
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
      font-family: "Times New Roman", Times, serif; 
    } 
    html {
      scroll-behavior: smooth;
    }
    section {
      scroll-margin-top: 80px;
    }

    @media (max-width: 768px) {
      #hero h1 { font-size: 1.6rem; }
      #hero h4 { font-size: 1rem; }
      #hero img { margin-bottom: 15px; }
    }

    #schedule h1 {
      color: #212529;
      font-weight: 700;
    }
    #schedule .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    #schedule .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    @media (max-width: 768px) {
      #schedule .row { justify-content: center; }
      #schedule h1 { font-size: 1.8rem; }
    }
     
    #profile {
    background-color: #e9f4ff;
    }

    #profile .profile-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .profile-img {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #0d6efd;
    box-shadow: 0 0 15px rgba(13,110,253,0.3);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .profile-img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(42, 28, 189, 0.5);
    }

    #profile h4 {
    color: #5a8dda;
    font-weight: bold;
    }

    #profile table {
    width: 100%;
    font-size: 1rem;
    }

    #profile table th {
    width: 40%;
    color: #5a8dda;
    }

    #profile table td {
    word-break: break-word;
    }

    @media (max-width: 768px) {
    #profile .profile-card {
    text-align: center;
    padding: 20px;
    }
    #profile table {
    font-size: 0.95rem;
    }
    #profile table th {
    text-align: left;
    width: 35%;
    }
    #profile table td {
    text-align: left;
    }
    }

    .dark-mode {
      background-color: #121212 !important;
      color: white !important;
    }
    .dark-mode .card {
      background-color: #1f1f1f;
      color: white;
    }
    .dark-mode nav,
    .dark-mode footer {
      background-color: #1f1f1f !important;
    }
    .dark-mode .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    .dark-mode .navbar-toggler { border-color: white; }
    .dark-mode .navbar,
    .dark-mode .navbar a,
    .dark-mode .navbar .nav-link,
    .dark-mode .navbar-brand { color: white !important; }
    .dark-mode .navbar .nav-link:hover { color: #cfe2ff !important; }
    .dark-mode footer a i { color: white !important; }
    .dark-mode footer a i:hover { color: #cfe2ff !important; }

    .theme-btn {
    border: none;
    background: transparent;
    font-size: 1.1rem; 
    margin-left: 5px;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.2s ease;
    }
    #lightBtn { color: #ffd21e; }
    #darkBtn { color: #cfe2ff; }
    .theme-btn:hover { transform: scale(1.2); opacity: 0.8; }
    .active-theme { transform: scale(1.3); text-shadow: 0 0 10px currentColor; }
    
    .schedule-card {
    border-radius: 20px;
    color: #fff;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
     }

    .schedule-card.senin {
    background: linear-gradient(135deg, #145aa4, #00b4ff);
    }
    .schedule-card.selasa {
    background: linear-gradient(135deg, #28a745, #7dd56f);
    }
    .schedule-card.rabu {
    background: linear-gradient(135deg, #dc3545, #ff758c);
    }
    .schedule-card.kamis {
    background: linear-gradient(135deg, #ff8a00, #ffc107);
    }
    .schedule-card.jumat {
    background: linear-gradient(135deg, #17a2b8, #5ee7df);
    }
    .schedule-card.sabtu {
    background: linear-gradient(135deg, #6c757d, #a3a3a3);
    }
    .schedule-card.minggu {
    background: linear-gradient(135deg, #343a40, #495057);
    }
    .schedule-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }
    .schedule-item i {
    font-size: 1.3rem;
    margin-right: 8px;
    }
    .schedule-item strong {
    font-size: 1.1rem;
    }
    .schedule-item small {
    font-style: italic;
    font-size: 0.9rem;
    opacity: 0.9;
    }
    .navbar .nav-link.active {
     color: #0d6efd !important;
     font-weight: 700;
     border-bottom: 2px solid #0d6efd;
     }
</style>
</head>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css"
     rel="stylesheet">
<body>
  <!-- nav begin -->
  <nav class="navbar navbar-expand-lg bg-light fixed-top shadow-sm">
    <div class="container-fluid px-0">
      <a class="navbar-brand fw-bold ms-3" href="#">My Daily Articel</a>
      <button
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0 pe-0">
          <li class="nav-item"><a class="nav-link" href="#hero">HOME</a></li>
          <li class="nav-item"><a class="nav-link" href="#article">ARTICEL</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">GALLERY</a></li>
          <li class="nav-item"><a class="nav-link" href="#schedule">SCHEDULE</a></li>
          <li class="nav-item"><a class="nav-link" href="#profile">PROFILE</a></li>
          <li class="nav-item">
            <a class="nav-link" href="login.php" target="_blank">login</a>
          </li>
        </ul>

        <!-- Tombol tema -->
        <div class="d-flex align-items-center ms-3">
          <button id="lightBtn" class="theme-btn active-theme" title="Light Mode">
            <i class="bi bi-brightness-high"></i>
          </button>
          <button id="darkBtn" class="theme-btn" title="Dark Mode">
            <i class="bi bi-moon-stars"></i>
          </button>
        </div>
      </div>
    </div>
  </nav>
  <!-- nav end -->

  <!-- hero begin -->
  <section id="hero" class="p-5 bg-primary-subtle text-center text-md-start mt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center order-1 order-md-2 mb-4 mb-md-0">
          <img src="fto1.jpg" class="img-fluid rounded shadow" width="300" alt="foto memori">
        </div>
        <div class="col-md-6 order-2 order-md-1">
          <h1 class="fw-bold display-5 mb-3">
            Create Memories, Save Memories, Everyday
          </h1>
          <h4 class="fw-normal mt-3">  
            Hello, Welcome to My Articel :)
          </h4>
          <h6>
            <span id="tanggal"></span>
            <span id="jam"></span>
          </h6>
        </div>  
      </div>
    </div>
  </section>
  <!-- hero end -->

 <!-- article begin -->
<section id="article" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      // gunakan nama tabel yang benar: articel
      $sql = "SELECT * FROM articel ORDER BY tanggal DESC";
      
      // gunakan variabel yang benar: $koneksi
      $hasil = $koneksi->query($sql);

      // jika tabel masih kosong, tidak error
      if ($hasil && $hasil->num_rows > 0) {

        while($row = $hasil->fetch_assoc()){
      ?>
          <div class="col">
            <div class="card h-100">
              <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="gambar artikel" />
              <div class="card-body">
                <h5 class="card-title"><?= $row["judul"]?></h5>
                <p class="card-text">
                  <?= $row["isi"]?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">
                  <?= $row["tanggal"]?>
                </small>
              </div>
            </div>
          </div>
      <?php
        }

      } else {
        echo "<p class='text-muted'>Belum ada artikel yang ditambahkan.</p>";
      }
      ?> 
    </div>
  </div>
</section>
<!-- article end -->

  <!-- gallery begin -->
  <section id="gallery" class="text-center p-5 bg-primary-subtle">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">Gallery</h1>

    <div class="row justify-content-center g-4">
      <?php
      $sql_gallery = "SELECT * FROM gallery ORDER BY id_gallery DESC";
      $gallery = $koneksi->query($sql_gallery);
      
      if ($gallery && $gallery->num_rows > 0) {
        while ($g = mysqli_fetch_assoc($gallery)) { ?>

        <div class="col-6 col-md-3">
          <div class="card shadow-sm h-100">
            <img 
              src="img/<?= $g['gambar']; ?>" 
              class="card-img-top"
              style="height:180px; object-fit:cover;"
              alt="<?= $g['judul']; ?>"
            >
            <div class="card-body">
              <h6 class="fw-bold"><?= $g['judul']; ?></h6>
              <p class="small"><?= $g['deskripsi']; ?></p>
            </div>
          </div>
        </div>
      <?php 
        }
      } else {
        echo "<p class='text-muted'>Belum ada galeri yang ditambahkan.</p>";
      }
      ?>
    </div>

  </div>
</section>
<!-- gallery end -->

<!-- SCHEDULE -->
  <section id="schedule" class="p-5">
    <div class="container text-center">
      <h1 class="fw-bold display-5 mb-5 text-primary">📚 Jadwal Kuliah & Kegiatanku</h1>
      <div class="row g-4 justify-content-start">

        <!-- Senin -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card senin border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Senin</h4>
              <div class="schedule-item">
                <i class="bi bi-alarm"></i> 10:20 - 12:00<br>
                <strong>Basis Data</strong><br>
                <small>Ruang H.5.4</small>
              </div>
              <hr>
              <div class="schedule-item">
                <i class="bi bi-laptop"></i> 12:30 - 15:00<br>
                <strong>Logika Informatika</strong><br>
                <small>Ruang H.5.3</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Selasa -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card selasa border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Selasa</h4>
              <div class="schedule-item">
                <i class="bi bi-code-slash"></i> 08:40 - 10:20<br>
                <strong>Basis Data</strong><br>
                <small>Ruang D.2.K</small>
              </div>
              <hr>
              <div class="schedule-item">
                <i class="bi bi-bank"></i> 12:30 - 14:10<br>
                <strong>Kewarganegaraan</strong><br>
                <small>Ruang E.3</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Rabu -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card rabu border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Rabu</h4>
              <div class="schedule-item">
                <i class="bi bi-bar-chart-line"></i> 07:00 - 09:30<br>
                <strong>Probabilitas & Statistik</strong><br>
                <small>Ruang H.5.11</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Kamis -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card kamis border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Kamis</h4>
              <div class="schedule-item">
                <i class="bi bi-cpu"></i> 08:40 - 10:20<br>
                <strong>Pemrograman Web</strong><br>
                <small>Ruang D.2.J</small>
              </div>
              <hr>
              <div class="schedule-item">
                <i class="bi bi-gear-wide-connected"></i> 12:30 - 15:00<br>
                <strong>Rekayasa Perangkat Lunak</strong><br>
                <small>Ruang H.4.3</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Jumat -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card jumat border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Jumat</h4>
              <div class="schedule-item">
                <i class="bi bi-gear"></i> 12:30 - 15:00<br>
                <strong>Sistem Operasi</strong><br>
                <small>Ruang H.5.3</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Sabtu -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card sabtu border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Sabtu</h4>
              <div class="schedule-item">
                <i class="bi bi-emoji-smile"></i><br>
                <strong>Tidak Ada Jadwal</strong>
              </div>
            </div>
          </div>
        </div>  

        <!-- Minggu -->
        <div class="col-12 col-md-3">
          <div class="card schedule-card minggu border-0 shadow h-100">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3 text-uppercase">Minggu</h4>
              <div class="schedule-item">
                <i class="bi bi-cup-hot"></i><br>
                <strong>Waktunya Istirahat</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
<!-- Profil -->
   <section id="profile" class="p-5 bg-primary-subtle">
    <div class="container">
    <h1 class="fw-bold display-5 pb-4 text-center">Profil Mahasiswa</h1>

    <div class="profile-card mx-auto" style="max-width: 800px;">
      <div class="row align-items-center justify-content-center g-4">
        <!-- Foto -->
        <div class="col-md-4 text-center">
          <img src="img/fotonia.jpg" alt="Foto Nia Ramadhani" class="profile-img">
        </div>

        <!-- Data -->
        <div class="col-md-8">
          <h4 class="mb-3">Nia Ramadhani</h4>
          <table class="table table-borderless mb-0">
            <tr>
              <th>NIM</th><td>: A11.2024.15677</td>
            </tr>
            <tr>
              <th>Program Studi</th><td>: Teknik Informatika</td>
            </tr>
            <tr>
              <th>Email</th><td>: niarmdhi1610@gmail.com</td>
            </tr>
            <tr>
              <th>Telepon</th><td>: 0895-3590-30968</td>
            </tr>
            <tr>
              <th>Alamat</th><td>: Jl. Gergaji Pelem No 16 Rt 02/Rw 06 Mugasari Semarang Selatan, Kota Semarang</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Profil End-->

<!-- footer begin -->
  <footer class="text-center p-5">
    <div>
      <a href="https://www.instagram.com/niarmdhi_"><i class="bi bi-instagram h2 p-2 text-dark"></i></a>
      <a href="https://wa.me/+62895359030968"><i class="bi bi-whatsapp h2 p-2 text-dark"></i></a>
      <a href="https://telegram.org/dl"><i class="bi bi-telegram h2 p-2 text-dark"></i></a>
    </div>
    <div>
      Nia Ramadhani &copy; 2025
    </div>
  </footer>
 <!-- footer end -->

<!-- Bootstrap -->
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous">
  </script>

<!-- Script waktu -->
  <script>
    function tampilwaktu() {
      const waktu = new Date();
      const bulan = waktu.getMonth() + 1;
      let jam = waktu.getHours();
      let menit = waktu.getMinutes();
      let detik = waktu.getSeconds();

      if (jam < 10) jam = "0" + jam;
      if (menit < 10) menit = "0" + menit;
      if (detik < 10) detik = "0" + detik;

      document.getElementById("tanggal").innerHTML =
        waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
      document.getElementById("jam").innerHTML =
        jam + ":" + menit + ":" + detik;

      setTimeout(tampilwaktu, 1000);
    }
    tampilwaktu();
  </script>
<!--Script Waktu End-->

<!-- Dark/Light Mode -->
  <script>
    const darkBtn = document.getElementById("darkBtn");
    const lightBtn = document.getElementById("lightBtn");
    const body = document.body;

    darkBtn.addEventListener("click", () => {
      body.classList.add("dark-mode");
      darkBtn.classList.add("active-theme");
      lightBtn.classList.remove("active-theme");
    });

    lightBtn.addEventListener("click", () => {
      body.classList.remove("dark-mode");
      lightBtn.classList.add("active-theme");
      darkBtn.classList.remove("active-theme");
    });
  </script>
<!--Dark/Light Mode End-->

 <!-- Navbar Scroll -->
<script>
  const navLinks = document.querySelectorAll('.nav-link');

  window.addEventListener('scroll', () => {
    let fromTop = window.scrollY + 120;

    navLinks.forEach(link => {
      let section = document.querySelector(link.getAttribute('href'));
      if (
        section.offsetTop <= fromTop &&
        section.offsetTop + section.offsetHeight > fromTop
      ) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  });
</script>
<!-- Navbar Scroll End-->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
     <script>
        AOS.init({
        duration: 1000, 
        once: true,     
        offset: 100   
         });
</script>

</body>
</html>  