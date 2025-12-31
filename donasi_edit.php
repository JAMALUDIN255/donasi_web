<?php
// donasi_edit.php
session_start();
require 'functions.php';
require 'koneksi.php';

if (!is_logged()) {
    header("Location: login.php");
    exit;
}
// 🚨 TAMBAHKAN PEMBATASAN INI:
if (!is_admin()) {
    header("Location: donasi.php"); // Alihkan kembali ke daftar (Lihat Saja)
    exit;
}
// ... sisa kode

// Cek ID di URL
if (!isset($_GET['id'])) {
    header("Location: donasi.php");
    exit;
}

$id_donasi = $_GET['id'];
$data_donasi = get_donasi_by_id($id_donasi); // Memanggil fungsi yang sudah diperbaiki

if (!$data_donasi) {
    header("Location: donasi.php");
    exit;
}

$msg = '';

// Proses update
if (isset($_POST['update'])) {
    $nama = $_POST['nama_donatur'] ?? $data_donasi['nama'];
    $barang = $_POST['barang_donasi'] ?? $data_donasi['barang'];
    $kontak = $_POST['kontak'] ?? $data_donasi['kontak'];

    // Panggil fungsi update_donasi_barang
    if (update_donasi_barang($id_donasi, $nama, $barang, $kontak)) {
        $msg = ['type' => 'success', 'text' => 'Data Donasi berhasil diperbarui.'];
        // Muat ulang data terbaru setelah update
        $data_donasi = get_donasi_by_id($id_donasi); 
    } else {
        // Debugging error database
        global $koneksi;
        $db_error = mysqli_error($koneksi);
        $msg = ['type' => 'danger', 'text' => "Gagal memperbarui data donasi. ERROR: " . htmlspecialchars($db_error)];
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Donasi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="page-title">✏️ Edit Donasi Barang</h2>
    <div class="card-custom">
        <div class="p-4">
            <?php if ($msg): ?>
                <div class="alert alert-<?= $msg['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($msg['text']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="donasi_edit.php?id=<?= $id_donasi ?>" method="POST">
                <div class="mb-3">
                    <label for="nama_donatur" class="form-label">Nama Donatur</label>
                    <input type="text" class="form-control" id="nama_donatur" name="nama_donatur" value="<?= htmlspecialchars($data_donasi['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="barang_donasi" class="form-label">Barang Donasi</label>
                    <input type="text" class="form-control" id="barang_donasi" name="barang_donasi" value="<?= htmlspecialchars($data_donasi['barang']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak Donatur (Telp/Email)</label>
                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?= htmlspecialchars($data_donasi['kontak']) ?>">
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="donasi.php" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>