<?php 
// donasi.php (FULL CODE REPLACE - TAMPILAN FINAL)
error_reporting(E_ALL); 
ini_set('display_errors', 1);

require 'functions.php';
require 'koneksi.php';

$is_admin = is_admin(); 
$donasi = get_all_donasi_barang(); 
$user = current_user();

global $koneksi;
if ($donasi === false) {
    die("ERROR FATAL! Query Donasi GAGAL. Pesan DB: " . mysqli_error($koneksi));
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Donasi Barang - Donasi Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h2 class="page-title">Donasi Barang</h2>

    <div class="card-custom">
        
        <div class="card-header-custom d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0">Daftar Donasi Masuk</h5>
            
            <?php if ($is_admin): ?>
            <a href="donasi_tambah.php" class="btn btn-primary btn-sm btn-rounded"><i class="bi bi-plus-circle me-1"></i> Tambah Donasi</a>
            <?php endif; ?>
        </div>

        <div class="p-4">

            <table class="table table-custom table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Nama Donatur</th>
                        <th>Barang Donasi</th>
                        <th style="width: 80px;">Jumlah</th>
                        <th>Kontak</th>
                        <th>Tanggal</th>
                        <?php if ($is_admin): ?>
                        <th style="width: 150px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                <?php if ($donasi && $donasi->num_rows > 0): ?>
                    <?php $no=1; while($d = $donasi->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($d['nama'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($d['barang'] ?? '-') ?></td>
                        
                        <td><?= htmlspecialchars($d['jumlah'] ?? '0') ?></td>

                        <td><?= htmlspecialchars($d['kontak'] ?? '-') ?></td>
                        
                        <td><?= date('d/m/Y', strtotime($d['tanggal_donasi'] ?? '')) ?></td>

                        <?php if ($is_admin): ?>
                        <td>
                            <a href="donasi_edit.php?id=<?= $d['id'] ?>" 
                               class="btn btn-primary btn-sm me-1">
                                ✏
                            </a>

                            <a href="donasi_hapus.php?id=<?= $d['id'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus data donasi ini?')"
                               class="btn btn-danger btn-sm">
                                🗑
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="<?= $is_admin ? 7 : 6 ?>" class="text-center py-4 text-muted">
                            Belum ada data donasi barang yang dicatat.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>