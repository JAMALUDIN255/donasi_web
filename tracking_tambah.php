<?php
// tracking_tambah.php (FULL CODE REPLACE - DENGAN SINKRONISASI STOK)
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

$user = current_user();
$msg = '';

if (isset($_POST['submit'])) {
    // TANGKAP INPUT
    $nama_barang  = $_POST['nama_barang'] ?? ''; 
    $jenis        = $_POST['jenis'] ?? '';
    $jumlah       = (int)($_POST['jumlah'] ?? 0);
    $keterangan   = $_POST['keterangan'] ?? '';
    $tanggal      = $_POST['tanggal'] ?? date('Y-m-d');

    if (empty($nama_barang) || empty($jenis) || empty($jumlah) || empty($keterangan) || $jumlah <= 0) {
        $msg = ['type' => 'danger', 'text' => 'Semua kolom wajib harus diisi dengan benar.'];
    } else {
        
        $stok_berkurang = true; // Flag untuk melacak status stok

        // 1. Cek jika jenis transaksinya adalah BARANG KELUAR (Disalurkan)
        if ($jenis == 'Disalurkan') {
            if (!kurangi_stok_donasi($nama_barang, $jumlah)) {
                $stok_berkurang = false;
                $msg = ['type' => 'danger', 'text' => 'Gagal mengurangi stok Donasi! Pastikan nama barang benar dan jumlah stok mencukupi di Data Donasi.'];
            }
        }
        // Jika jenisnya "Diterima" atau "Lainnya", stok tidak dikurangi, jadi $stok_berkurang tetap true.

        if ($stok_berkurang) {
            // 2. Jika stok berhasil dikurangi (atau tidak perlu dikurangi), simpan data Tracking
            if (tambah_tracking($nama_barang, $jenis, $jumlah, $keterangan, $tanggal)) {
                $msg = ['type' => 'success', 'text' => 'Data Tracking dicatat. Stok Donasi telah diperbarui jika termasuk barang keluar. Mengalihkan...'];
                header("refresh:3;url=tracking.php"); 
                exit;
            } else {
                // Gagal menyimpan Tracking
                global $koneksi;
                $db_error = mysqli_error($koneksi);
                $msg = ['type' => 'danger', 'text' => "Peringatan: Gagal menyimpan Tracking. ERROR DB: " . htmlspecialchars($db_error)];
            }
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Tracking Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="page-title">➕ Catat Tracking Barang Baru</h2>
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
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required placeholder="Tulis nama barang sama persis seperti di Data Donasi">
                </div>
                
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Transaksi</label>
                    <select class="form-select" id="jenis" name="jenis" required>
                        <option value="">Pilih Status</option>
                        <option value="Diterima">Diterima Gudang (Barang Masuk)</option>
                        <option value="Disalurkan">Disalurkan (Barang Keluar)</option>
                        <option value="Lainnya">Lainnya (Perbaikan, Retur, dll.)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required placeholder="Jumlah barang">
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required placeholder="Detail lokasi atau status saat ini"></textarea>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Tracking</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="tracking.php" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" name="submit" class="btn btn-primary">💾 Simpan Tracking</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>