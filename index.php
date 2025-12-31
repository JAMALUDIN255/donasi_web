<?php
require 'functions.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Donasi Web - Selamat Datang</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Styling for the landing page */
    body { 
        font-family: 'Inter', sans-serif; 
        min-height: 100vh; 
        color: #fff;
        position: relative; 
        
        /* === PERUBAHAN UTAMA UNTUK BACKGROUND GAMBAR === */
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url('bg_donasi.jpg'); 
        /* 0.4 dan 0.5 adalah tingkat kegelapan overlay */
        background-size: cover; /* Memastikan gambar mengisi seluruh layar */
        background-position: center; /* Memastikan gambar berada di tengah */
        background-attachment: fixed; /* Membuat gambar tetap saat discroll */
        /* ============================================== */
    }
    .app-header { padding: 15px 0; }
    .hero { padding: 50px 0 80px 0; }
    .hero-title { font-size: 3rem; font-weight: 700; line-height: 1.2; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    .hero-subtitle { font-size: 1.2rem; opacity: 0.9; text-shadow: 1px 1px 3px rgba(0,0,0,0.5); }
    .btn-main-sm { background: #ffffff; color: #5b86e5; font-weight: 600; padding: 8px 15px; border-radius: 8px; transition: 0.2s; }
    .btn-main-sm:hover { background: #f0f0f0; color: #4d77d1; }
    .promo-badge { padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 20px; display: inline-block; margin-bottom: 15px; backdrop-filter: blur(4px); font-weight: 600; letter-spacing: .5px; }
    .hero-img { width: 100%; max-width: 480px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2)); }
    .public-links a { color: #fff; opacity: 0.9; margin-right: 15px; transition: 0.2s; text-decoration: none; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
    .public-links a:hover { opacity: 1; text-decoration: underline; }
    /* Styling for the WhatsApp button */
    .btn-whatsapp { 
        background-color: #25D366; 
        border-color: #25D366; 
        font-weight: 700; 
        font-size: 1.1rem;
        padding: 12px 30px;
        margin-top: 25px;
        transition: background-color 0.2s;
    }
    .btn-whatsapp:hover {
        background-color: #128C7E;
        border-color: #128C7E;
    }
    /* Styling for the footer */
    .app-footer { 
        position: absolute; 
        bottom: 0; 
        width: 100%; 
        background: rgba(0, 0, 0, 0.4); /* Meningkatkan kegelapan footer agar teks terbaca */
        padding: 10px 0; 
        font-size: 0.85rem;
    }
  </style>
</head>

<body>

<div class="container">
    
    <header class="app-header d-flex justify-content-end">
        <a href="login.php" class="btn btn-main-sm">Login Admin</a>
    </header>
    
    <div class="hero">
        <div class="row align-items-center">
            
            <div class="col-md-6">
                <div class="promo-badge">🎁 Donasi Sekarang!</div>

                <h1 class="hero-title">Selamat Datang di<br>Donasi Web</h1>

                <p class="hero-subtitle mt-3 mb-4">
                    Platform donasi barang yang memudahkan kamu berbagi. Cepat, aman, dan transparan.
                </p>

                <a href="https://wa.me/6281210912173?text=Assalamualaikum%2C%20saya%20tertarik%20untuk%20berdonasi%20barang." 
                   target="_blank" 
                   class="btn btn-whatsapp text-white shadow-lg">
                    <i class="bi bi-whatsapp me-2"></i> **DONASI SEKARANG VIA WA**
                </a>
                <h5 class="fw-bold mt-5 mb-3">Akses Informasi Publik:</h5>
                <div class="public-links">
                    <a href="dashboard.php" class="me-3"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
                    <a href="donasi.php" class="me-3"><i class="bi bi-heart-fill me-1"></i> Data Donasi</a>
                    <a href="penyaluran.php" class="me-3"><i class="bi bi-truck me-1"></i> Penyaluran</a>
                    <a href="tracking.php"><i class="bi bi-geo-alt me-1"></i> Tracking</a>
                </div>

            </div>

            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="https://cdn-icons-png.flaticon.com/512/3063/3063822.png"
                    class="hero-img"
                    alt="Donasi">
            </div>
    </div> </div> <footer class="app-footer">
    <div class="container text-center">
        &copy; <?= date('Y') ?> | **221011403324_Jamaludin_Pemograman II**
    </div>
</footer>
</body>
</html>
        </div>
    </div>

</div>

</body>
</html>