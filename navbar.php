<?php
require 'functions.php'; // Pastikan functions dimuat
$user = current_user();
$is_admin = is_admin();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">Donasi Web</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="donasi.php">Data Donasi</a></li>
        <li class="nav-item"><a class="nav-link" href="penyaluran.php">Penyaluran</a></li>
        <li class="nav-item"><a class="nav-link" href="tracking.php">Tracking</a></li>
      </ul>

      <span class="navbar-text me-3">
        Halo, <?= htmlspecialchars($user['nama'] ?? 'Pengunjung') ?>
      </span>

      <?php if (is_logged()): ?>
          <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
      <?php else: ?>
          <a href="login.php" class="btn btn-light btn-sm">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>