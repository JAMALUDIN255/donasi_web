<?php
// tracking.php (FULL CODE REPLACE - TAMPILKAN NAMA BARANG)
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
    <title>Tracking Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold page-title">Tracking Barang</h3>
        <?php if ($is_admin): ?>
            <a href="tracking_tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> Tambah Tracking</a>
        <?php endif; ?>
    </div>

    <div class="card-custom p-4">

    <?php
    $q = $conn->query("SELECT * FROM tracking ORDER BY id DESC");
    ?>

    <table class="table table-custom table-hover table-striped mt-3">
        <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <?php if ($is_admin): ?>
            <th style="width: 150px;">Aksi</th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>
        <?php
        if ($q === false) {
            global $koneksi;
            echo "<tr><td colspan='". ($is_admin ? 7 : 6) . "' class='text-center text-danger'>ERROR DB: Query tracking gagal. Pesan: " . mysqli_error($koneksi) . "</td></tr>";
        } elseif ($q->num_rows > 0) {
            $i = 1;
            while ($t = $q->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($t['nama_barang'] ?? 'Tidak Ada Nama') ?></td>
                <td><?= $t['jenis'] ?></td>
                <td><?= $t['jumlah'] ?></td>
                <td><?= htmlspecialchars($t['keterangan']) ?></td>
                <td><?= $t['tanggal'] ?></td>
                
                <?php if ($is_admin): ?>
                <td>
                    <a href="tracking_edit.php?id=<?= $t['id'] ?>" class="btn btn-primary btn-sm me-1">✏</a>
                    <a href="tracking_hapus.php?id=<?= $t['id'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">🗑</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='". ($is_admin ? 7 : 6) . "' class='text-center py-4 text-muted'>Belum ada data tracking.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'footer.php'; ?>