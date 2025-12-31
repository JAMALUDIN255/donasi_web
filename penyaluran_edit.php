<?php
// penyaluran_edit.php (FULL CODE REPLACE - FIX LOGIKA NAMA BARANG)
session_start();
require 'functions.php';
require 'koneksi.php';

// PENGAMANAN KRITIS: Hanya Admin yang boleh akses.
if (!is_logged() || !is_admin()) {
    header("Location: penyaluran.php"); 
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: penyaluran.php");
    exit;
}

$id_penyaluran = $_GET['id'];
$data_penyaluran = get_penyaluran_by_id($id_penyaluran);

if (!$data_penyaluran) {
    // Jika ID di URL tidak ditemukan di DB
    header("Location: penyaluran.php");
    exit;
}

$msg = '';

if (isset($_POST['update'])) {
    // TANGKAP INPUT NAMA BARANG BARU
    $nama_barang = $_POST['nama_barang'] ?? $data_penyaluran['nama_barang'];
    $jumlah      = $_POST['jumlah'] ?? $data_penyaluran['jumlah'];
    $penerima    = $_POST['penerima'] ?? $data_penyaluran['penerima'];
    $tanggal     = $_POST['tanggal'] ?? $data_penyaluran['tanggal'];

    // Panggil fungsi update_penyaluran dengan NAMA BARANG
    if (update_penyaluran($id_penyaluran, $nama_barang, $jumlah, $penerima, $tanggal)) { 
        $msg = ['type' => 'success', 'text' => 'Data Penyaluran berhasil diperbarui.'];
        // Muat ulang data terbaru setelah update
        $data_penyaluran = get_penyaluran_by_id($id_penyaluran); 
    } else {
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
    <title>Edit Penyaluran Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="page-title">✏️ Edit Data Penyaluran</h2>
    <div class="card-custom">
        <div class="p-4">
            <?php if ($msg): ?>
                <div class="alert alert-<?= $msg['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($msg['text']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="penyaluran_edit.php?id=<?= $id_penyaluran ?>" method="POST">
                
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($data_penyaluran['nama_barang']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data_penyaluran['jumlah']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="penerima" class="form-label">Penerima</label>
                    <input type="text" class="form-control" id="penerima" name="penerima" value="<?= htmlspecialchars($data_penyaluran['penerima']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Penyaluran</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data_penyaluran['tanggal']) ?>" required>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="penyaluran.php" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>