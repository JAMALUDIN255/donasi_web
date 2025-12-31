<?php
// donasi_tambah.php
session_start();
require 'functions.php';
require 'koneksi.php';

// CEK LOGIN DAN ROLE ADMIN (HARUS LOGIN DAN HARUS ADMIN)
if (!is_logged() || !is_admin()) {
    header("Location: donasi.php"); 
    exit;
}

$user = current_user();
$msg = '';

if (isset($_POST['submit'])) {
    // Perhatikan urutan variabel post
    $nama = $_POST['nama_donatur'] ?? '';
    $barang = $_POST['barang_donasi'] ?? '';
    $jumlah = $_POST['jumlah'] ?? 0; // <<< TANGKAP JUMLAH
    $kontak = $_POST['kontak'] ?? '';

    // Tambahkan validasi jumlah
    if (empty($nama) || empty($barang) || empty($jumlah) || $jumlah == 0) {
        $msg = ['type' => 'danger', 'text' => 'Nama donatur, barang, dan jumlah harus diisi.'];
    } else {
        // Panggil fungsi dengan parameter jumlah baru
        if (tambah_donasi_barang($nama, $barang, $jumlah, $kontak)) { 
            $msg = ['type' => 'success', 'text' => 'Donasi barang berhasil dicatat.'];
            header("refresh:2;url=donasi.php"); 
        } else {
            global $koneksi;
            $db_error = mysqli_error($koneksi);
            $msg = ['type' => 'danger', 'text' => "Gagal mencatat donasi. ERROR: " . htmlspecialchars($db_error)];
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Donasi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="page-title">➕ Catat Donasi Barang Baru</h2>
    <div class="card-custom">
        <div class="p-4">
            <?php if ($msg): ?>
                <div class="alert alert-<?= $msg['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($msg['text']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nama_donatur" class="form-label">Nama Donatur</label>
                    <input type="text" class="form-control" id="nama_donatur" name="nama_donatur" required>
                </div>
                <div class="mb-3">
                    <label for="barang_donasi" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="barang_donasi" name="barang_donasi" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak Donatur (Telp/Email)</label>
                    <input type="text" class="form-control" id="kontak" name="kontak">
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="donasi.php" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" name="submit" class="btn btn-primary">💾 Simpan Donasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>