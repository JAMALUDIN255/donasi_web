<?php
// penyaluran.php (FULL CODE REPLACE - FIX ERROR 'b.nama_barang')
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'koneksi.php';
require 'functions.php';

$conn = $GLOBALS['conn'];
$is_admin = is_admin(); // Cek peran user
?>
<!DOCTYPE html>
<html>
<head>
    <title>Penyaluran Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold page-title">Data Penyaluran Barang</h3>
        <?php if ($is_admin): ?>
            <a href="penyaluran_tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> Tambah Penyaluran</a>
        <?php endif; ?>
    </div>

    <div class="card-custom p-4">

        <table class="table table-custom table-hover table-striped">
            <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama Barang</th> 
                <th>Jumlah</th>
                <th>Penerima</th>
                <th>Tanggal</th>
                <?php if ($is_admin): ?>
                <th style="width: 150px;">Aksi</th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>
            <?php
            // QUERY DIBUAT SEDERHANA: Hanya mengambil data dari tabel penyaluran
            $q = $conn->query("SELECT * FROM penyaluran ORDER BY id DESC");
            $i = 1;

            if ($q === false) {
                global $koneksi;
                echo "<tr><td colspan='". ($is_admin ? 6 : 5) . "' class='text-center text-danger'>ERROR DB: Query penyaluran gagal. Pesan: " . mysqli_error($koneksi) . "</td></tr>";
            } elseif ($q->num_rows > 0) {
                while ($p = $q->fetch_assoc()) {
                    // Semua referensi ke tabel 'barang' atau 'b.nama_barang' dihapus.
            ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($p['nama_barang'] ?? 'Nama Tidak Ada') ?></td>
                    <td><?= $p['jumlah'] ?></td>
                    <td><?= htmlspecialchars($p['penerima']) ?></td>
                    <td><?= date('d/m/Y', strtotime($p['tanggal'] ?? $p['tanggal_penyaluran'] ?? '')) ?></td>
                    
                    <?php if ($is_admin): ?>
                    <td>
                        <a href="penyaluran_edit.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm me-1">✏</a>
                        <a href="penyaluran_hapus.php?id=<?= $p['id'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">🗑</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='". ($is_admin ? 6 : 5) . "' class='text-center py-4 text-muted'>Belum ada data penyaluran.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>
<?php include 'footer.php'; ?>