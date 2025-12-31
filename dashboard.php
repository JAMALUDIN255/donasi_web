<?php
// dashboard.php
require 'functions.php';
require 'koneksi.php';

// HAPUS Pengecekan is_logged() agar Akses Publik Diizinkan

$user = current_user(); // User mungkin null (Pengunjung)
$conn = $GLOBALS['conn']; // Pastikan $conn tersedia
$is_admin = is_admin(); // Cek role

$total_donasi = $conn->query("SELECT COUNT(*) AS jml FROM donasi")->fetch_assoc()['jml'] ?? 0;
$total_penyaluran = $conn->query("SELECT COUNT(*) AS jml FROM penyaluran")->fetch_assoc()['jml'] ?? 0;
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard - Donasi Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* CSS yang memastikan sidebar dan konten tampil benar */
        body { font-family: 'Inter', sans-serif; background: #f5f8ff; }
        .sidebar { width: 260px; height: 100vh; background: #ffffff; position: fixed; left: 0; top: 0; padding: 25px; box-shadow: 5px 0 20px rgba(0, 0, 0, 0.08); }
        .sidebar h3 { font-weight: 700; margin-bottom: 30px; }
        .sidebar a { display: block; padding: 12px 15px; margin-bottom: 8px; border-radius: 10px; color: #333; text-decoration: none; font-weight: 500; }
        .sidebar a:hover, .active-menu { background: #4facfe; color: white !important; }
        .content { margin-left: 280px; padding: 25px; }
        .card-stat { border: none; border-radius: 15px; padding: 25px; box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08); }
        .navbar-custom { border-radius: 15px; background: white; padding: 15px; box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08); }
        .profile-box { text-align: right; font-weight: 600; }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>Donasi Web</h3>

        <a href="dashboard.php" class="active-menu"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="donasi.php"><i class="bi bi-heart-fill me-2"></i> Data Donasi</a>
        <a href="penyaluran.php"><i class="bi bi-truck me-2"></i> Penyaluran</a>
        <a href="tracking.php"><i class="bi bi-geo-alt me-2"></i> Tracking</a>
        
        <?php if (is_logged()): // Logout hanya jika sudah login ?>
            <a href="logout.php" class="mt-4"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
        <?php endif; ?>
    </div>

    <div class="content">

        <div class="navbar-custom mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Dashboard</h4>
            <div class="profile-box">
                Halo, <?= $user['nama'] ?? 'Pengunjung'; ?>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-stat">
                    <h5>Total Donasi Dicatat</h5>
                    <h1 class="fw-bold text-success">
                        <?= $total_donasi ?>
                    </h1>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-stat">
                    <h5>Total Penyaluran</h5>
                    <h1 class="fw-bold text-warning">
                        <?= $total_penyaluran ?>
                    </h1>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-stat">
                    <h5>User Aktif</h5>
                    <h1 class="fw-bold text-primary">
                        <?php 
                        $q = $conn->query("SELECT COUNT(*) AS jml FROM users");
                        echo $q->fetch_assoc()['jml'];
                        ?>
                    </h1>
                </div>
            </div>
        </div>
        <hr class="my-5">
        <div class="card p-4 shadow-sm border-0 rounded-4">
            <h5 class="fw-bold mb-3">Grafik Donasi</h5>
            <img src="https://quickchart.io/chart?c={type:'bar',data:{labels:['Jan','Feb','Mar','Apr'],datasets:[{label:'Donasi',data:[3,5,2,8]}]}}" 
                 class="img-fluid rounded">
        </div>
        <div class="container py-4">
    
    <div class="mb-4">
        <a href="index.php" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-house-door-fill me-1"></i> Kembali ke Halaman Utama
        </a>
    </div>
    <h2 class="page-title">Dashboard Pendonasi</h2>
    <p>Selamat datang, <?= htmlspecialchars($user['nama'] ?? 'Admin') ?>. Anda dapat mengelola data melalui menu di atas.</p>
    
    </div>
    </div>
</body>
</html>