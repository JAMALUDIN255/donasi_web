<?php
// tracking_edit.php (FULL CODE REPLACE - FINAL FIX DENGAN NAMA BARANG)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'functions.php';
require 'koneksi.php';

// PENGAMANAN KRITIS: Hanya Admin yang boleh akses.
if (!is_logged() || !is_admin()) {
    header("Location: tracking.php"); 
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: tracking.php");
    exit;
}

$id_tracking = $_GET['id'];
// Ambil data tracking berdasarkan ID
$data_tracking = get_tracking_by_id($id_tracking);

if (!$data_tracking) {
    header("Location: tracking.php");
    exit;
}

$msg = '';

if (isset($_POST['update'])) {
    // TANGKAP INPUT NAMA BARANG
    $nama_barang  = $_POST['nama_barang'] ?? $data_tracking['nama_barang'];
    $jenis        = $_POST['jenis'] ?? $data_tracking['jenis'];
    $jumlah       = $_POST['jumlah'] ?? $data_tracking['jumlah'];
    $keterangan   = $_POST['keterangan'] ?? $data_tracking['keterangan'];
    $tanggal      = $_POST['tanggal'] ?? $data_tracking['tanggal'];

    // Panggil fungsi update_tracking() dengan NAMA BARANG
    if (update_tracking($id_tracking, $nama_barang, $jenis, $jumlah, $keterangan, $tanggal)) {
        $msg = ['type' => 'success', 'text' => 'Data Tracking berhasil diperbarui.'];
        // Muat ulang data terbaru setelah update
        $data_tracking = get_tracking_by_id($id_tracking); 
    } else {
        // TANGKAP ERROR DATABASE JIKA GAGAL
        global $koneksi;
        $db_error = mysqli_error($koneksi);
        $msg = ['type' => 'danger', 'text' => "Gagal memperbarui. ERROR DB: " . htmlspecialchars($db_error)];
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Tracking Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="page-title">✏️ Edit Data Tracking</h2>
    <div class="card-custom">
        <div class="p-4">
            <?php if ($msg): ?>
                <div class="alert alert-<?= $msg['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($msg['text']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="tracking_edit.php?id=<?= $id_tracking ?>" method="POST">
                
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($data_tracking['nama_barang']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Transaksi</label>
                    <select class="form-select" id="jenis" name="jenis" required>
                        <option value="Diterima" <?= ($data_tracking['jenis'] == 'Diterima' ? 'selected' : '') ?>>Diterima Gudang (Barang Masuk)</option>
                        <option value="Disalurkan" <?= ($data_tracking['jenis'] == 'Disalurkan' ? 'selected' : '') ?>>Disalurkan (Barang Keluar)</option>
                        <option value="Lainnya" <?= ($data_tracking['jenis'] == 'Lainnya' ? 'selected' : '') ?>>Lainnya (Perbaikan, Retur, dll.)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data_tracking['jumlah']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?= htmlspecialchars($data_tracking['keterangan']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Tracking</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars(date('Y-m-d', strtotime($data_tracking['tanggal']))) ?>" required>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="tracking.php" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>